#!/usr/bin/env perl

use strict;
use DBI;
use DBD::mysql;
use IO::File;
use LWP;
use XML::RSS;
use XML::Simple;
use XML::Parser::Expat; 
use MIME::Lite;

use POSIX qw(WNOHANG setsid strftime mktime);

use Data::Dumper; # For debug only

use constant PID_FILE => '/var/run/vacuum.pid';
use constant CALENDAR => 'http://xml.fxstreet.com/fundamental/economic-calendar/events.xml'; 

my $quit = 0;

# Database connection params
my $database = 'option';
my $hostname = 'localhost';
my $user     = 'root';
my $password = '';
my $port     = 3306;

# The signals handler
$SIG{CHLD} = sub { while (waitpid(-1, WNOHANG) > 0) {} };
$SIG{TERM} = $SIG{INT} = sub { $quit++ };


# Start of program
my $fh = open_pid_file(PID_FILE);
warn "$0 startting......\n";
my $pid = become_daemon();
print $fh $pid;
close $fh;


# Database connection
my $dsn = "DBI:mysql:database=$database;host=$hostname;port=$port";
my $dbh = DBI->connect($dsn, $user, $password);
my $drh = DBI->install_driver("mysql");

# Arrays of symbols
my @indices    = ();
my @commodites = ();
my @currency   = ();
my @stock      = ();
my @open_games = (); # Array of open games
my @current_quotes = (); # Array of quotes for open games
my @news = (); # Array of news
my @calendar = (); # Array of finance dates

###################### Main Loop ########################
while (!$quit) {
    sleep(3);
    get_all_open_games();
    if (@open_games) {
        get_all_assets();
        get_quotes_for_games();
        insert_game_data();
    }
    put_calendar();
    # Clean UP
    @open_games     = ();
    @commodites     = ();
    @currency       = ();
    @stock          = ();
    @indices        = ();
    @open_games     = ();
    @current_quotes = ();
    @news           = ();
    @calendar       = ();
    sleep(3);
}
#########################################################


# Function become_daemon
# Makes the background
sub become_daemon {
    die "Can't fork" unless defined (my $child = fork);
    if ($child) {
        exit 0;
    }
    setsid();
    #open(STDIN,  "</dev/null");
    #open(STDOUT, ">/dev/null");
    #open(STDERR, ">&STDOUT");
    chdir '/';
    umask(0);
    $ENV{PATH} = '/bin:/sbin:/usr/bin:/usr/sbin';
    return $$;
}


# Function open_pid_file
# Check and open new pid file(if need)
sub open_pid_file {
    my $file = shift;
    if (-e $file) {
        my $fh = IO::File->new($file) || return;
        my $pid = <$fh>;
        if (kill(0, $pid)) {
            die "Server already running with PID $pid";
        }
        warn "Removing PID file for defunct server process $pid. \n";
        die "Can't unlink PID file $file"
            unless -w $file && unlink $file;
    }
    return IO::File->new($file, O_WRONLY|O_CREAT|O_EXCL, 0644)
         or die "Can't create $file: $!\n";
}


# Function get_all_assets
# Getting all symbols
sub get_all_assets {
    # Get stock
    my $sth = $dbh->prepare("SELECT *FROM symbols_company");
    $sth->execute();
    while (my $ref = $sth->fetchrow_hashref()) {
        push(@stock, $ref);
    }
    $sth->finish();
    # Get currencies
    $sth = $dbh->prepare("SELECT *FROM symbols_currency");
    $sth->execute();
    while (my $ref = $sth->fetchrow_hashref()) {
        push(@currency, $ref);
    }
    $sth->finish();
    # Get indices 
    $sth = $dbh->prepare("SELECT *FROM symbols_indices");
    $sth->execute();
    while (my $ref = $sth->fetchrow_hashref()) {
        push(@indices, $ref);
    }
    $sth->finish();
    # Get commodities
    $sth = $dbh->prepare("SELECT *FROM symbols_metall");
    $sth->execute();
    while (my $ref = $sth->fetchrow_hashref()) {
        push(@commodites, $ref);
    }
    $sth->finish();
}

# Function get_all_open_games
# Getting open games
sub get_all_open_games {
    my $sth = $dbh->prepare("SELECT *FROM game WHERE game_result IS NULL");
    $sth->execute();
    while (my $ref = $sth->fetchrow_hashref()) {
        push(@open_games, $ref);
    }
    $sth->finish();
}

# Function create_yahoo_query
# Creating query for yahoo finance
# return $query
sub create_yahoo_query {
    my $query      = 'http://download.finance.yahoo.com/d/quotes.csv?s=';
    my $key        = 'snl1w4jkpa2';
    my $short_name = ''; 
    foreach (@open_games) {
        my $temp = $_->{asset};
        foreach (@indices) {
            $short_name = $_->{short_name};
            if ($_->{full_name} eq $temp) {
                if ($query eq 'http://download.finance.yahoo.com/d/quotes.csv?s=') {
                    $query .= $short_name;
                }
                else {
                    my $t = $short_name;
                    $t =~ s/\^//g;
                    if ($query !~ m/$t/) {
                        #$query .= '+' . $_->{short_name};
                        $query .= '+' . $short_name;
                    }
                }
            }
        }
        foreach (@commodites) {
            $short_name = $_->{short_name};
            if ($_->{full_name} eq $temp) {
                if ($query eq 'http://download.finance.yahoo.com/d/quotes.csv?s=') {
                    if (($_->{full_name} eq 'Gold to USD') or ($_->{full_name} eq 'Silver to USD')) {
                        $query .= $short_name . '=X';
                    }
                    else {
                        $query .= $short_name;
                    }
                }
                else {
                    my $t = $short_name;
                    $t =~ s/\^//g;
                    if ($query !~ m/$t/) {
                        if (($_->{full_name} eq 'Gold to USD') or ($_->{full_name} eq 'Silver to USD')) {
                            $query .= '+' . $short_name . '=X';
                        }
                        else {
                            $query .= '+' . $short_name;
                        }
                    }
                }
            }
        }
        foreach (@stock) {
            $short_name = $_->{short_name};
            if ($_->{full_name} eq $temp) {
                if ($query eq 'http://download.finance.yahoo.com/d/quotes.csv?s=') {
                    $query .= $short_name;
                }
                else {
                    my $t = $short_name;
                    $t =~ s/\^//g;
                    if ($query !~ m/$t/) {
                        $query .= '+' . $short_name;
                    }
                }
            }
        }
        foreach (@currency) {
            $short_name = $_->{short_name};
            if ($_->{full_name} eq $temp) {
                if ($query eq 'http://download.finance.yahoo.com/d/quotes.csv?s=') {
                    $query .= $short_name . '=X';
                }
                else {
                    my $t = $short_name;
                    $t =~ s/\^//g;
                    if ($query !~ m/$t/) {
                        $query .= '+' . $short_name . '=X';
                    }
                }
            }
        }
    }
    $query .= '&f=' . $key;
    return $query;
}

# Function get_short_asset_name
# Getting short name of asset
# param: full_name
# return: short_name
sub get_short_asset_name {
    my $full_name = shift;
    my $short_name;
    my $sth = $dbh->prepare("SELECT short_name FROM symbols_company WHERE full_name='$full_name'");
    $sth->execute();
    while (my $ref = $sth->fetchrow_hashref()) {
        $short_name = $ref->{short_name};
    }
    if (!$short_name) {
        my $sth = $dbh->prepare("SELECT short_name FROM symbols_currency WHERE full_name='$full_name'");
        $sth->execute();
        while (my $ref = $sth->fetchrow_hashref()) {
            $short_name = $ref->{short_name};
        }
    }
    if (!$short_name) {
        my $sth = $dbh->prepare("SELECT short_name FROM symbols_indices WHERE full_name='$full_name'");
        $sth->execute();
        while (my $ref = $sth->fetchrow_hashref()) {
            $short_name = $ref->{short_name};
        }
    }
    if (!$short_name) {
        my $sth = $dbh->prepare("SELECT short_name FROM symbols_metall WHERE full_name='$full_name'");
        $sth->execute();
        while (my $ref = $sth->fetchrow_hashref()) {
            $short_name = $ref->{short_name};
        }
    }
    return $short_name;
}

# Function get_quotes_for_games
# Getting quotes for open games from yahoo finance
sub get_quotes_for_games {
    my @row_quotes = ();
    my $url      = create_yahoo_query();
    my $ua       = LWP::UserAgent->new();
    my $response = $ua->get($url);
    my $low;
    my $high;
    my $close;
    my $volume;
    @row_quotes = split(/^/, $response->content);
    foreach (@row_quotes) {
        my @temp = split(/,/, $_);
        $temp[0] =~ s/"//g;
        $temp[0] =~ s/=X//;
        $low     = $temp[4];
        $low     = $temp[2] if $low =~ m/N\/A/;
        $high    = $temp[5];
        $high    = $temp[2] if $high =~ m/N\/A/;
        $close   = $temp[6];
        $close   = $temp[2] if $close =~ m/N\/A/;
        $volume  = $temp[7];
        push(@current_quotes, {$temp[0] => $temp[2], $temp[0] . '_low' => $low, $temp[0] . '_high' => $high, $temp[0] . '_close' => $close, $temp[0] . '_volume' => $volume});
    }
}

# Function get_quote_price
# Getting price of quote by short name of asset
# param: short_name
# return: quote_price 
sub get_quote_price {
    my $short_name  = shift;
    my @quote_info  = ();
    foreach (@current_quotes) {
        $quote_info[0] = $_->{$short_name} if defined $_->{$short_name};
        $quote_info[1] = $_->{$short_name . '_low'} if defined $_->{$short_name . '_low'};
        $quote_info[2] = $_->{$short_name . '_high'} if defined $_->{$short_name . '_high'};
        $quote_info[3] = $_->{$short_name . '_close'} if defined $_->{$short_name . '_close'};
        $quote_info[4] = $_->{$short_name . '_volume'} if defined $_->{$short_name . '_volume'};
    }
    return @quote_info;
}

# Function insert_game_data
# Inserting qoutes of open games into game_data table
sub insert_game_data {
    foreach (@open_games) {
        my $short_name  = get_short_asset_name($_->{asset});
        my $table_name  = get_table_name($short_name);
        my @quote_info  = get_quote_price($short_name);
        my $quote_price = $quote_info[0];
        my $quote_low   = $quote_info[1];
        my $quote_high  = $quote_info[2];
        my $quote_close = $quote_info[3];
        my $quote_vol   = $quote_info[4];
        my $in_money    = status_of_game($_->{strategy}, $_->{price}, $_->{price_from}, $_->{price_to}, $quote_price);
        my $sth = $dbh->prepare("INSERT INTO $table_name(game_id, symbol, price, min_d, max_d, close, volume, in_money) VALUES($_->{id}, '$short_name', '$quote_price', '$quote_low', '$quote_high', '$quote_close', '$quote_vol', '$in_money')");
        close_expired_games($_->{expired_at}, $_->{id}, $in_money);
        $sth->execute();
        $sth->finish();
    }
}

# Function status_of_game
# Checking status of game
# params: strategy, price, price_from, price_to, current_price
# return: status
sub status_of_game {
    my ($strategy, $price, $price_from, $price_to, $current_price) = @_;
    my $status = 0;
    if ($strategy eq 'call') {
        $status = 1 if $price < $current_price;
    }
    if ($strategy eq 'put') {
        $status = 1 if $price > $current_price;
    }
    if ($strategy eq 'touch') {
        $status = 1 if $price == $current_price;
    }
    if ($strategy eq 'no touch') {
        $status = 1 if $price != $current_price;
    }
    if ($strategy eq 'bounderi out') {
        $status = 1 if $price_from == $current_price or $price_to == $current_price;
    }
    if ($strategy eq 'bounderi inside') {
        $status = 1 if $price_from < $current_price or $price_to > $current_price;
    }
    return $status;
}

# Function close_expired_games
# Closing expired games
# params: expired_time, game_id, game_status
sub close_expired_games {
    my ($expired_time, $game_id, $game_status) = @_;
    my $is_expired   = 0;
    my $current_time = strftime("%Y-%m-%d %H:%M:%S", localtime);
    my @a = split(/\D/, $expired_time);
    my ($sec, $min, $hour, $mday, $mon, $year) = ($a[5], $a[4], $a[3], $a[2], $a[1]-1, $a[0]-1900);
    my $exp_mktime = mktime($sec, $min, $hour, $mday, $mon, $year);
    @a = split(/\D/, $current_time);
    ($sec, $min, $hour, $mday, $mon,$year) = ($a[5], $a[4], $a[3], $a[2], $a[1]-1, $a[0]-1900);
    my $cur_mktime = mktime($sec, $min, $hour, $mday, $mon, $year);
    if ($cur_mktime >= $exp_mktime) {
        my $sth = $dbh->prepare("UPDATE game SET game_result=$game_status WHERE id=$game_id");
        $sth->execute();
        change_user_balance($game_id);
        $sth->finish();
    }
}

# Function get_table_name
# Getting table name by quote
# params: quote
# return table
sub get_table_name {
    my $symbol = shift;
    my $table  = 'game_data_';
    my @smbarr = split(//, $symbol);
    my $limit  = 4;
    my $symlen = length($symbol);
    $limit = $symlen if $symlen < $limit;

    my $sum = 0;

    for (my $i = 0; $i < $limit; $i++) {
        $sum += ord($smbarr[$i]);
    }
    $table .= ($sum % 26);
    return $table;
}

# Function change_user_balance
# Changing user balance
# params: game_id
sub change_user_balance {
    my $game_id  = shift;
    my $game_res = 0;
    my $invest   = 0;
    my $user_id  = 0;
    my $balance  = 0; 
    my $sth = $dbh->prepare("SELECT * FROM game WHERE id=$game_id");
    $sth->execute();
    while (my $ref = $sth->fetchrow_hashref()) {
        $game_res = $ref->{game_result};
        $invest   = $ref->{investment};
        $user_id  = $ref->{user_id};
    }
    $sth = $dbh->prepare("SELECT user_cache FROM user_money WHERE user_id=$user_id");
    $sth->execute();
    while (my $ref = $sth->fetchrow_hashref()) {
        $balance = $ref->{user_cache};
    }
    if ($game_res == 0) {
        $invest = $invest * 0.15;
    }
    elsif ($game_res == 1) {
        $invest = $invest * 1.85;
    }
    $balance += $invest; 
    $sth = $dbh->prepare("UPDATE user_money SET user_cache=$balance");
    $sth->execute();
    send_user_alert($user_id, $game_res, $game_id);
}

# Function send_user_alert
# Sending alert to user
# params: user_id, game_result, game_id

sub send_user_alert {
    my ($user_id, $game_result, $game_id) = @_;
    my $email      = '';
    my $asset      = '';
    my $username   = '';
    my $ispost     = '';
    my $investment = '';
    my $is_alert   = 0;
    my $sth = $dbh->prepare("SELECT * FROM user_money WHERE user_id=$user_id");
    $sth->execute();
    while (my $ref = $sth->fetchrow_hashref()) {
        $email    = $ref->{email};
        $is_alert = $ref->{alert}; 
        $username = $ref->{username};
    }
    if ($is_alert == 1) {
        $sth = $dbh->prepare("SELECT * FROM game WHERE id=$game_id");
        $sth->execute();
        while (my $ref = $sth->fetchrow_hashref()) {
            $asset = $ref->{asset};
            $investment = $ref->{investment};
            $ispost = $ref->{is_post};
        }
        $email = 'User<' . $email . '.>';
        $game_result  = "<html><body>Hi $username,<br />The Expiry Time of Your $investment Investment in $asset has expired.<br />";
        $game_result .= "Congratulations! Your Trade was Successful!<br />" if $game_result == 1;
        $game_result .= "Unfortunately, Your Trade was Unsuccessful.<br />" if $game_result == 0;
        $game_result .= "Next time share it with the rest of the forum members.<br />" if $ispost == 0;
        $game_result .= "Thanks for sharing with the Forum Members - Keep it Up!<br />" if $ispost == 1;
        $game_result .= "Regards,<br /><br />";
        $game_result .= "Communitraders Team";
        $game_result .= "</body></html>";
        my $msg = MIME::Lite->new (
            From    => 'Rado<2011jacketsshop@gmail.com.>',
            To      => $email,
            Type    => 'text/html',
            Subject => 'Your trade finished',
            Data    => $game_result
        );
        $msg->send;
    }
}


# Function get_calendar
# Getting calendar
sub get_calendar {
    my $ua       = LWP::UserAgent->new();
    my $response = $ua->get(CALENDAR);
    my $rss = new XML::RSS;
    $rss->parse($response->content);
    foreach (@{$rss->{items}}) {
        push(@calendar, {'title' => $_->{title}, 'link' => $_->{link}, 'description' => $_->{description}});
    }
    for (my $i; $i < @calendar; $i++) {
        $calendar[$i]->{description} = cut_description($calendar[$i]->{description}, $calendar[$i]->{link}, $calendar[$i]->{title});
    }
}

# Function cut_description
# Cutting not need html code
sub cut_description {
    my ($description) = @_;
    $description =~ s/(<table cellpadding\=\"5\"><tr><td><strong>Date \(GMT\)<\/strong><\/td><td><strong>Event<\/strong><\/td><td><strong>Cons\.<\/strong><\/td><td><strong>Actual<\/strong><\/td><td><strong>Previous<\/strong><\/td><\/tr>)(.*)(<\/table>)(.*)/$2<tr><td colspan=\"5\">$4<\/td><\/tr>/;
    $description =~ s/<a\s+/<a target=\"_blank\"/g;
    #$description =~ s/(<table cellpadding\=\"5\"><tr><td><strong>Date \(GMT\)<\/strong><\/td><td><strong>Event<\/strong><\/td><td><strong>Cons\.<\/strong><\/td><td><strong>Actual<\/strong><\/td><td><strong>Previous<\/strong><\/td><\/tr>)(.*)(<\/table>)(.*)/$2/;
    return $description;
}

# Function put_calendar
# Insert calendar into the database
sub put_calendar {
    my $title       = '';
    my $link        = '';
    my $description = '';
    my $sth = $dbh->prepare("SELECT id FROM finance_calendar WHERE need_update_at < NOW() LIMIT 1");
    $sth->execute();
    if ($sth->rows) {
        get_calendar();
        if (@calendar) {
            $sth = $dbh->prepare("DELETE FROM finance_calendar WHERE id != ''");
            $sth->execute();
            foreach (@calendar) {
                $title       = $dbh->quote($_->{title});
                $link        = $_->{link};
                $description = $_->{description};
                $sth = $dbh->prepare("INSERT INTO finance_calendar (description, title, link, need_update_at) VALUES(?, ?, ?, NOW() + INTERVAL 10 HOUR)");
                $sth->execute($description, $title, $link);
            }
        }
    }
}

END { unlink PID_FILE if $$ == $pid; }
