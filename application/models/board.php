<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Board extends DataMapper {

	static $cached = array();
	var $has_one = array();
	var $has_many = array();
	var $validation = array(
		'board_shortname' => array(
			'rules' => array('required', 'max_length' => 256),
			'label' => 'Board',
			'type' => 'input'
		),
		'board_name' => array(
			'rules' => array('required', 'max_length' => 256),
			'label' => 'Board Name',
			'type' => 'input'
		),
		'board_url' => array(
			'rules' => array('required', 'max_length' => 256),
			'label' => 'Board URL',
			'type' => 'input'
		),
		'thread_refresh_rate' => array(
			'rules' => array(),
			'label' => 'Thread Refresh Rate',
			'type' => 'input'
		),
		'threads_posts' => array(
			'rules' => array('is_int'),
			'label' => 'Thread Threads',
			'type' => 'input'
		),
		'threads_media' => array(
			'rules' => array('is_int'),
			'label' => 'Media Threads',
			'type' => 'input'
		),
		'threads_thumb' => array(
			'rules' => array('is_int'),
			'label' => 'Thumb Threads',
			'type' => 'input'
		),
		'max_ancient_id' => array(
			'rules' => array('is_int'),
			'label' => 'Description',
			'type' => 'input'
		),
		'max_indexed_id' => array(
			'rules' => array('is_int'),
			'label' => 'Description',
			'type' => 'input'
		)
	);
	
	
	function __construct($id = NULL)
	{		
		parent::__construct($id);
	}

	
	function post_model_init($from_cache = FALSE)
	{
		
	}
	
	
	public function add($data = array())
	{
		if (!$this->update_board_db($data))
		{
			log_message('error', 'add_board: failed writing to database');
			return false;
		}
		
		if (!$this->add_board_dir())
		{
			log_message('error', 'add_board: failed creating board directory');
			return false;
		}
		
		return true;
	}
	
	
	public function remove()
	{
		/*
		if (!$this->remove_board_dir())
		{
			log_message('error', 'remove_board: failed to remove board directory');
			return false;
		}
		*/
		
		if (!$this->remove_board_db())
		{
			log_message('error', 'remove_board: failed to remove database entry');
			return false;
		}
		
		return true;
	}
	
	
	public function update_board_db($data = array())
	{
		if (isset($data["id"]) && $data["id"] != '')
		{
			$this->where("id", $data["id"])->get();
			if ($this->result_count() == 0)
			{
				set_notice('error', 'The board you wish to modify doesn\'t exist.');
				log_message('error', 'update_board_db: failed to find requested id');
				return false;
			}
		}
		
		foreach ($data as $key => $value)
		{
			$this->$key = $value;
		}
		
		if ((!isset($this->id) || $this->id == ''))
		{
			$i = 1;
			$found = FALSE;
			
			$board = new Board();
			$board->where('board_shortname', $this->board_shortname)->get();
			if ($board->result_count() == 0)
			{
				$found = TRUE;
			}
			
			while (!$found)
			{
				$i++;
				$new_shortname = $this->board_shortname . '_' . $i;
				$board = new Board();
				$board->where('board_shortname', $new_shortname)->get();
				if ($board->result_count() == 0)
				{
					$this->board_shortname = $new_shortname;
					$found = TRUE;
				}
			}
		}
		
		if (isset($old_shortname) && $old_shortname != $this->board_shortname && is_dir("content/boards/" . $old_shortname))
		{
			$dir_old = "content/boards/" . $old_shortname;
			$dir_new = "content/boards/" . $new_shortname;
			rename($dir_old, $dir_new);
		}
		
		if (!$this->save())
		{
			if (!$this->valid)
			{
				set_notice('error', 'Please check that you have filled all of the required fields.');
				log_message('error', 'update_board_db: failed validation check');
			}
			else
			{
				set_notice('error', 'Failed to save this entry to the database for unknown reasons.');
				log_message('error', 'update_board_db: failed to save entry');
			}
			return false;
		}
		
		return true;
	}
	
	
	public function remove_board_db()
	{
		if (!$this->delete())
		{
			set_notice('error', 'This board couldn\t be removed from the database for unknown reasons.');
			log_message('error', 'remove_board_db: failed to remove requested id');
			return false;
		}
		
		return true;
	}
	
	
	public function add_board_dir()
	{
		if (!mkdir("content/boards/" . $this->directory()))
		{
			set_notice('error', 'The directory for this board could not be created. Please check your file permissions.');
			log_message('error', 'add_board_dir: failed to create board directory');
			return false;
		}
		return true;
	}
	
	
	public function remove_board_dir()
	{
		// Place Holder
	}
	
	public function directory()
	{
		return $this->board_shortname;
	}
}