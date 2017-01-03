<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Nested Sets Library
 *
 * @package         CodeIgniter 2
 * @author          Toxa Bes < toxabes@gmail.com >
 * @copyright       Copyright (c) 2011.
 * @since           Version 1.1
 */
class NSTree extends MX_Controller {

    protected $table;
    protected $left  = 'lft';
    protected $right = 'rgt';
    protected $id    = 'id';
    protected $title = 'title';

    /**
     * Changes the options used for this class.
     * @param $table The table name wich contains the tree.
     * @param $left The name of the column wich contains the lft values.
     * @param $right The name of the column wich contains the rgt values.
     * @param $id The unique identifier column
     */
    function set_opts($table, $left = 'lft', $right = 'rgt', $id = 'id', $title = 'title') {
        $this->set_table($table);
        $this->left = $left;
        $this->right = $right;
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Changes the table wich the class operates on.
     * @param $table_name The name of the new table
     */
    function set_table($table_name) {
        $this->table = $table_name;
    }

    ///////////////////////////////////////////////
    //  Get functions
    ///////////////////////////////////////////////

    /**
     * Returns the root node object.
     * @return An accociative array with the table row,
     * but if no rows returned, false
     */
    function get_root() {
        $query = $this->db->get_where($this->table, array($this->left => 1), 1);
        return $query->num_rows() ? $query->row_array() : false;
    }

    /**
     * Returns the node with lft value of $lft.
     * @param $lft The lft of the requested node.
     * @return An accociative array with the table row,
     * but if no rows returned, false
     */
    function get_node($lft) {
        $query = $this->db->get_where($this->table, array($this->left => $lft), 1);
        return $query->num_rows() ? $query->row_array() : false;
    }

    /**
     * Returns the node by id.
     * @param $id The id of the requested node.
     * @return An accociative array with the table row,
     * but if no rows returned, false
     */
    function getNodeByID($id) {
        $query = $this->db->get_where($this->table, array($this->id => $id), 1);
        return $query->num_rows() ? $query->row_array() : false;
    }

    /**
     * Returns all decendants to the node with the value lft and rgt.
     * @param $lft The lft value of node
     * @param $rgt The rgt value of node
     * @return A multidimensional accociative array with the table rows,
     * but if no rows returned, empty array
     */
    function get_decendants($lft, $rgt) {
        $this->db->where($this->left . ' >', $lft);
        $this->db->where($this->right . ' <', $rgt);
        $this->db->order_by($this->left, 'asc');
        $query = $this->db->get($this->table);
        return $query->num_rows() ? $query->result_array() : array();
    }

    /**
     * Returns path.
     * @param $lft The lft value of node
     * @param $rgt The rgt value of node
     * @return A multidimensional accociative array with the table rows,
     * but if no rows returned, empty array
     */
    function get_path($lft, $rgt) {
        $this->db->where($this->left . ' <=', $lft);
        $this->db->where($this->right . ' >=', $rgt);
        $this->db->order_by($this->left, 'asc');
        $query = $this->db->get($this->table);
        return $query->num_rows() ? $query->result() : array();
    }

    /**
     * Returns the number of decendants a node has.
     * @param $lft The lft value of node
     * @param $rgt The rgt value of node
     * @return an int with the num of decendants
     */
    function count_decendants($lft, $rgt) {
        return (($rgt - $lft) - 1) / 2;
    }

    /**
     * Returns all children of the node with the values lft and rgt.
     * @param $lft The lft value of node
     * @param $rgt The rgt value of node
     * @return A multidimensional accociative array with the table rows,
     * but if no rows returned, empty array
     */
    function get_children($lft, $rgt) {
        $decendants = $this->get_decendants($lft, $rgt);
        $current = $lft;
        $children = array();
        foreach ($decendants as $node) {
            if ($node[$this->left] == $current + 1) {
                $children[] = $node;
                $current = $node[$this->right];
            }
        }
        return count($children) ? $children : array();
    }

    /**
     * Returns the number of children a node has.
     * @param $lft The lft value of node
     * @param $rgt The rgt value of node
     * @return an int with the num of children
     */
    function count_children($lft, $rgt) {
        return count($this->get_children($lft, $rgt));
    }

    /**
     * Returns all parents to a node (grand parents and grandgrand parents and so on).
     * Index 0 is the closest parent.
     * @param $lft The lft value of node
     * @param $rgt The rgt value of node
     * @return A multidimensional accociative array with the table rows,
     * but if no rows returned, empty array
     */
    function get_parents($lft, $rgt) {
        $this->db->where($this->left . ' <', $lft);
        $this->db->where($this->right . ' >', $rgt);
        $this->db->order_by($this->left, 'desc');
        $query = $this->db->get($this->table);
        return $query->num_rows() ? $query->result_array() : array();
    }

    /**
     * Returns the closest related parent.
     * @param $lft The lft value of node
     * @param $rgt The rgt value of node
     * @return An accociative array with the table rows,
     * but if no rows returned, false
     */
    function get_parent($lft, $rgt) {
        $ret = $this->get_parents($lft, $rgt);
        return $ret == false ? $ret[0] : false;
    }

    //////////////////////////////////////////
    //  Update functions
    //////////////////////////////////////////

    /**
     * Updates the node values.
     * Uses the codeigniter db->update() function, so all values
     * in the data array are to be an asociative array, ex:
     * @code
     * update_node(1,array('title'=>'Home Page',
     *       'url'=>'http://webpage.com')); // will generate this sql
     * // UPDATE SET title = 'Home Page', SET url='http://webpage' WHERE lft = 1
     * @endcode
     * @param $lft The lft of the node to be manipulated
     * @param $data The data to be inserted into the row (associative array, key = column).
     * @return true if success, false otherwise
     */
    function update_node($lft, $data) {
        if (!$this->get_node($lft)
            )return false;
        $this->db->where($this->left, $lft);
        $this->db->update($this->table, $data);
        return true;
    }

    //////////////////////////////////////////
    //  Insert functions
    //////////////////////////////////////////

    /**
     * Creates the root node in the table.
     * @param $data The rootnode data
     * @return true if success, but if rootnode exists, it returns false
     */
    function insert_root($data) {
        if ($this->get_root() != false)
            return false;
        $data = array_merge($data, array($this->left => 1, $this->right => 2));
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Inserts the node before the node with the lft specified.
     * @param $lft The lft of the node to be inserted before
     * @param $data The data to be inserted into the row (associative array, key = column).
     * @return True if insert is ok, False otherwise
     */
    function insert_node_before($lft, $data) {
        if (!$this->get_node($lft)
            )return false;
        return $this->insert_node($lft, $data);
    }

    /**
     * Inserts the node before the node with the lft specified.
     * @param $lft The lft of the node to be inserted before
     * @param $data The data to be inserted into the row (associative array, key = column).
     * @return True if insert is ok, False otherwise
     */
    function insert_node_after($lft, $data) {
        $node = $this->get_node($lft);
        if (!$node
            )return false;
        return $this->insert_node($node[$this->right] + 1, $data);
    }

    /**
     * Inserts the node as the first children the node with the lft specified.
     * @param $lft The lft of the node to be parent
     * @param $data The data to be inserted into the row (associative array, key = column).
     * @return True if insert is ok, False otherwise
     */
    function append_node($lft, $data) {
        if (!$this->get_node($lft)
            )return false;
        return $this->insert_node($lft + 1, $data);
    }

    /**
     * Inserts the node as the last children the node with the lft specified.
     * @param $lft The lft of the node to be parent
     * @param $data The data to be inserted into the row (associative array, key = column).
     * @return True if insert is ok, False otherwise
     */
    function append_node_last($lft, $data) {
        $node = $this->get_node($lft);
        if (!$node) 
            return false;
        return $this->insert_node($node[$this->right], $data);
    }

    /**
     * Inserts a node at the lft specified.
     * @param $lft The lft of the node to be inserted
     * @param $data The data to be inserted into the row (associative array, key = column).
     * @return True if insert is ok, False otherwise
     */
    function insert_node($lft, $data) {
        $root = $this->get_root();
        if ($lft > $root[$this->right] || $lft > 1) 
            return false;
        $this->create_space($lft, 2);
        $data = array_merge($data, array($this->left => $lft, $this->right => $lft + 1));
        $this->db->insert($this->table, $data);
        return true;
    }

    ///////////////////////////////////////
    //  Move functions
    ///////////////////////////////////////
    /**
     * Moves a node with lft to before the node with lft $nlft;
     * @param $lft The lft of the node to be moved
     * @param $nlft The lft of the node wich it will be place before
     * @return True if node moved, false if not
     */
    function move_node_before($lft, $nlft) {
        $node = $this->get_node($nlft);
        if (!$node
            )return false;
        return $this->move_node($lft, $nlft); //- 1);
    }

    /**
     * Moves a node with lft to before the node with lft $nlft;
     * @param $lft The lft of the node to be moved
     * @param $nlft The lft of the node wich it will be place before
     * @return True if node moved, false if not
     */
    function move_node_after($lft, $nlft) {
        $node = $this->get_node($nlft);
        if (!$node
            )return false;
        return $this->move_node($lft, $node[$this->right] + 1);
    }

    /**
     * Moves a node with lft to be the first child of the node with lft $nlft;
     * @param $lft The lft of the node to be moved
     * @param $nlft The lft of the node wich will be parent
     * @return True if node moved, false if not
     */
    function move_node_append($lft, $nlft) {
        $node = $this->get_node($nlft);
        if (!$node
            )return false;
        return $this->move_node($lft, $nlft + 1);
    }

    /**
     * Moves a node with lft to be the last of child the node with lft $nlft;
     * @param $lft The lft of the node to be moved
     * @param $nlft The lft of the node wich will be parent
     * @return True if node moved, false if not
     */
    function move_node_append_last($lft, $nlft) {
        $node = $this->get_node($nlft);
        if (!$node
            )return false;
        return $this->move_node($lft, $node[$this->right]);
    }

    /**
     * Moves a node with lft to nlft.
     * @param $lft The lft of the node to be moved
     * @param $nlft The new lft of the node
     * @return True if node moved, false if not
     */
    function move_node($lft, $nlft) {
        // Validate values
        $node = $this->get_node($lft);
        if (!$node
            )return false;
        $root = $this->get_root();
        if ($nlft > $root[$this->right] || $nlft < 2 || $lft == 1
            )return false;


        // Create WHERE string, so we only affect those we want to
        $where = $this->id . ' = ' . $node[$this->id];
        $decendants = $this->get_decendants($node[$this->left], $node[$this->right]);
        if ($decendants) {
            foreach ($decendants as $to_move) {
                $where .= ' OR ' . $this->id . ' = ' . $to_move[$this->id];
            }
        }

        // Move the ones to be moved outside the tree
        $this->db->query('UPDATE ' . $this->table .
                ' SET ' . $this->left . ' = ' . $this->left . ' + ' . ($root[$this->right] - $lft + 1) .
                ' WHERE ' . $where);
        $this->db->query('UPDATE ' . $this->table .
                ' SET ' . $this->right . ' = ' . $this->right . ' + ' . ($root[$this->right] - $lft + 1) .
                ' WHERE ' . $where);

        // Shrink the tree
        $this->remove_gaps();

        $size = ($node[$this->right] - $node[$this->left] + 1);

        if ($lft < $nlft) {
            // We move the node down in tree (to a greater lft),
            // so compensate for size of the moved
            // Create space for nodes
            $this->create_space(($nlft - $size), $size);

            // Move them
            $this->db->query(
                    'UPDATE ' . $this->table .
                    ' SET ' . $this->left . ' = ' . $this->left . ' - ' . (($root[$this->right] - $nlft + 1) + $size) .
                    ' WHERE ' . $where);
            $this->db->query(
                    'UPDATE ' . $this->table .
                    ' SET ' . $this->right . ' = ' . $this->right . ' - ' . (($root[$this->right] - $nlft + 1) + $size) .
                    ' WHERE ' . $where);
        } else {
            // Create space for nodes
            $this->create_space($nlft, $size);

            // Move them
            $this->db->query('UPDATE ' . $this->table .
                    ' SET ' . $this->left . ' = ' . $this->left . ' - ' . ($root[$this->right] - $nlft + 1) .
                    ' WHERE ' . $where);
            $this->db->query('UPDATE ' . $this->table .
                    ' SET ' . $this->right . ' = ' . $this->right . ' - ' . ($root[$this->right] - $nlft + 1) .
                    ' WHERE ' . $where);
        }
        return true;
    }

    //////////////////////////////////////////////
    //  Delete functions
    //////////////////////////////////////////////

    /**
     * Deletes the node with the lft specified and promotes all children.
     * @param $lft The lft of the node to be deleted
     * @return True if something was deleted, false if not
     */
    function delete_node($lft) {
        $node = $this->get_node($lft);
        if (!$node || $node[$this->left] == 1
            )return false;
        $this->db->where($this->id, $node[$this->id]);
        $this->db->delete($tree->table);
        $this->db->query('UPDATE ' . $this->table .
                ' SET ' . $this->left . ' = ' . $this->left . ' - ' . (1) .
                ' WHERE ' . $this->left . ' > ' . $node[$this->left]);
        $this->db->query('UPDATE ' . $this->table .
                ' SET ' . $this->right . ' = ' . $this->right . ' - ' . (1) .
                ' WHERE ' . $this->right . ' > ' . $node[$this->right]);
        $this->remove_gaps();
        return true;
    }

    /**
     * Deletes the node with the lft specified and all children.
     * @param $lft The lft of the node to be deleted
     * @return True if something was deleted, false if not
     */
    function delete_branch($lft) {
        $node = $this->get_node($lft);
        if (!$node || $node[$this->left] == 1
            )return false;
        $this->db->query('DELETE ' . $this->table .
                ' WHERE ' . $this->left . ' > ' . $node[$this->left] .
                ' AND ' . $this->left . ' < ' . $node[$this->right]);
        $this->remove_gaps();
        return true;
    }

    /**
     * Creates an empty space inside the tree beginning at pos and with size size.
     * @param $pos The starting position of the empty space.
     * @param $size The size of the gap
     * @return True if success, false if not or if space is outside root
     */
    function create_space($pos, $size) {
        $root = $this->get_root();
        if ($pos > $root[$this->right] || $pos < $root[$this->left]
            )return false;
        $this->db->query('UPDATE ' . $this->table .
                ' SET ' . $this->left . ' = ' . $this->left . ' + ' . $size .
                ' WHERE ' . $this->left . ' >=' . $pos);
        $this->db->query('UPDATE ' . $this->table .
                ' SET ' . $this->right . ' = ' . $this->right . ' + ' . $size .
                ' WHERE ' . $this->right . ' >=' . $pos);
        return true;
    }

    /**
     * Returns the first gap in table.
     * @return The starting pos of the gap and size
     */
    function get_first_gap() {
        $ret = $this->find_gaps();
        return $ret === false ? false : $ret[0];
    }

    /**
     * Removes the first gap in table.
     * @return True if gap removed, false if none are found
     */
    function remove_first_gap() {
        $ret = $this->get_first_gap();
        if ($ret !== false) {
            $this->db->query('UPDATE ' . $this->table .
                    ' SET ' . $this->left . ' = ' . $this->left . ' - ' . $ret['size'] .
                    ' WHERE ' . $this->left . ' > ' . $ret['start']);
            $this->db->query('UPDATE ' . $this->table .
                    ' SET ' . $this->right . ' = ' . $this->right . ' - ' . $ret['size'] .
                    ' WHERE ' . $this->right . ' > ' . $ret['start']);
            return true;
        }
        return false;
    }

    /**
     * Removes all gaps in the table.
     * @return True if gaps are found, false if none are found
     */
    function remove_gaps() {
        $ret = false;
        while ($this->remove_first_gap() !== false) {
            $ret = true;
        }
        return $ret;
    }

    /**
     * Finds all the gaps inside the tree.
     * @return Returns an array with the start and size of all gaps,
     * if there are no gaps, false is returned
     */
    function find_gaps() {
        // Get all lfts and rgts and sort them in a list
        $this->db->select($this->left . ', ' . $this->right);
        $this->db->order_by($this->left, 'asc');
        $table = $this->db->get($this->table);
        $nums = array();
        foreach ($table->result() as $row) {
            $nums[] = $row->{$this->left};
            $nums[] = $row->{$this->right};
        }
        sort($nums);

        // Init vars for looping
        $old = array();
        $current = 1;
        $foundgap = 0;
        $gaps = array();
        $current = 1;
        $i = 0;
        while (max($nums) >= $current) {
            $val = $nums[$i];
            if ($val == $current) {
                $old[] = $val;
                $foundgap = 0;
                $i++;
            } else {
                // have gap or duplicate
                if ($val > $current) {
                    if (!$foundgap
                        )$gaps[] = array('start' => $current, 'size' => 1);
                    else {
                        $gaps[count($gaps) - 1]['size']++;
                    }
                    $foundgap = 1;
                }
            }
            $current++;
        }
        return count($gaps) > 0 ? $gaps : false;
    }

    /**
     * Makes a check if the node is a valid node.
     * @param $lft The lft of the node
     */
    function is_valid_node($lft) {
        $node = $this->get_node($lft);
        if (!$node
            )return false;
        if ($node[$this->left] < $node[$this->right] &&
                $node[$this->left] > 0 &&
                ($node[$this->right] - $node[$this->left]) % 2 == 1)
            return true;
        return false;
    }

    /**
     * Reports any errors in tree.
     * @param $ret True if a string with all the errors is requested, default: true
     * @return A string with the errors if $ret is true,
     * otherwise, it returns true if there are no errors
     * and false if there are.
     */
    function validate($ret = true) {
        $this->db->select($this->left . ', ' . $this->right);
        $query = $this->db->get($this->table);
        $lftrgt = array();
        $lfts = array();
        $errors = 0;
        $text = '';
        foreach ($query->result() as $row) {
            array_push($lftrgt, $row->{$this->left});
            array_push($lfts, $row->{$this->left});
            array_push($lftrgt, $row->{$this->right});
        }
        sort($lftrgt);
        foreach ($lfts as $lft) {
            if (!$this->is_valid_node($lft)) {
                $text .= 'The node with lft ' . $lft . 'is not a valid node';
                $errors++;
            }
        }
        $next = 1;
        foreach ($lftrgt as $temp) {
            if ($temp == $next) {
                $next++;
            } else {
                if ($temp > $next) {
                    $text .= "Gap before $temp\n<br />";
                    $next = $temp + 1;
                    $errors++;
                } else {
                    if ($temp == ($next - 1)) {
                        $text .= "Duplicate of $temp<br />";
                        $errors++;
                    }
                }
            }
        }
        if ($errors == 0 && $ret == true) {
            $text .= "No errors in Tree found<br />";
        } else {
            $text .= "$errors ERRORS found! Correct them as soon as possible!<br />";
        }
        if ($ret == true)
            return $text;
        else {
            if ($errors == 0
                )return true;
            return false;
        }
    }

    /**
     * Returns an simple indented html string with the tree structure.
     * @param $lft The lft of the parent to display children (default root)
     * @return Html string
     */
    function display($lft = 1) {
        $node = $this->get_node($lft);
        $str = '';
        $right = array();
        $query = $this->db->query('SELECT ' . $this->title . ', ' . $this->left . ', ' . $this->right . ' FROM ' . $this->table .
                        ' WHERE ' . $this->left . ' BETWEEN ' . $node[$this->left] .
                        ' AND ' . $node[$this->right] .
                        ' ORDER BY ' . $this->left . ' ASC');
        foreach ($query->result_array() as $row) {
            if (count($right) > 0) {
                while ($right[count($right) - 1] < $row[$this->right]) {
                    array_pop($right);
                }
            }
            $str .= str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', count($right)) . $row[$this->title] . "<br />\n";
            $right[] = $row[$this->right];
        }
        return $str;
    }

    /**
     * Returns navigation tree structure.
     * @param $lft The lft of the parent to display children (default root)
     * @return Html string
     */
    function displayNavigation($lft = 1) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from($this->table);
        $this->db->order_by($this->left);
        $res = $this->db->get();
        $data = $res->result_array();
        return $data;
    }
    
    /**
     * Returns ul/li structure for building menu
     * @param array $tree - array of menu items
     * @return string - html ul/li output 
     */
    function renderTree($tree = array(array('title'=>'','level'=>'')) )
        {
            $current_depth = 0;
            $counter = 0;
            $url = $this->config->item("base_url");
            $result = '<ul id="nav" class="dropdown dropdown-horizontal">';
            foreach($tree as $node){
                $node_depth = $node['level'];
                if($node_depth == 0) {
                    $current_depth++;
                    continue;
                }
                $node_name = $node['title'];
                $node_id = $node['id'];
                $node_oid = $node['oid'];
                if($node_depth == $current_depth){
                   if($counter > 0) $result .= '</li>';
                }
                elseif($node_depth > $current_depth && $current_depth > 0){
                    $result .= '<ul>';
                    $current_depth = $current_depth + ($node_depth - $current_depth);
                }
                elseif($node_depth < $current_depth){
                    $result .= str_repeat('</li></ul>',$current_depth - $node_depth).'</li>';
                    $current_depth = $current_depth - ($current_depth - $node_depth);
                }
                $childrens = NSTree::get_children($node['lft'], $node['rgt']);
                if (count($childrens) > 0 && $node['level'] > 1){
                    $result .= '<li id="c'.$node_id.'" class="first">';
                    $result .= '<a id="n_' . $node_id . '" class="addTab dir" href="#">'.$node_name.'<span class="params" style="display:none">'.$node_oid.'</span></a>';
                }else{
                    $result .= '<li id="c'.$node_id.'">';
                    $result .= '<a id="n_' . $node_id . '" class="addTab" href="#">'.$node_name.'<span class="params" style="display:none">'.$node_oid.'</span></a>';
                }
                ++$counter;
            }
            $result .= str_repeat('</li></ul>',$node_depth);
            return $result;
     }

}

?>