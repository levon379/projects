#!/bin/bash
#Version 1.7.0 Revision #${dist.revision}
echo "Registering AnyChart Stock Folder in FlashPlayer Security Trust Folder..."
unamestr=`uname`
FL_ANYCHART="$PWD"
if [ "$unamestr" = 'Darwin' ]
then
	#mac
	if [ -d "$HOME/Library/Preferences/Macromedia/Flash Player/#Security" ]
		then echo "..."
	else
		mkdir "$HOME/Library/Preferences/Macromedia/Flash Player/#Security"
	fi
	if [ -d "$HOME/Library/Preferences/Macromedia/Flash Player/#Security/FlashPlayerTrust" ]
		then echo "..."
	else
		mkdir "$HOME/Library/Preferences/Macromedia/Flash Player/#Security/FlashPlayerTrust"
	fi
	FP_SEC="$HOME/Library/Preferences/Macromedia/Flash Player/#Security/FlashPlayerTrust"
else
	#linux
	if [ -d $HOME/.macromedia/Flash_Player/\#Security ]
		then echo "..."
	else
		mkdir $HOME/.macromedia/Flash_Player/\#Security
	fi
	if [ -d $HOME/.macromedia/Flash_Player/\#Security/FlashPlayerTrust ]
		then echo "..."
	else
		mkdir $HOME/.macromedia/Flash_Player/\#Security/FlashPlayerTrust
	fi
	FP_SEC=$HOME/.macromedia/Flash_Player/\#Security/FlashPlayerTrust
fi

if [ -e "$FP_SEC/anychartstock.cfg" ]
then
	if grep "$FL_ANYCHART$" "$FP_SEC/anychartstock.cfg" >> /dev/null
		then echo "..."
	else 
		echo "$FL_ANYCHART">>"$FP_SEC/anychartstock.cfg"
	fi
else
	echo "$FL_ANYCHART">>"$FP_SEC/anychartstock.cfg"
fi

echo "Done. Please restart your Browser if it launched."
exit 
