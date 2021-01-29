<?php

class Todo extends Eloquent {
  
	public static $table = 'users_todos';
  
  /**
  * Loads a todo if it exists and belongs to the given user.
  */
  public static function load_todo($issue_id = 0, $user_id = 0) {
		if (!$user_id) $user_id = Auth::user()->id;
    
    $todo = Todo::where('issue_id', '=', $issue_id)->where('user_id', '=', $user_id)->first();
    if(empty($todo)) {
      return FALSE;
    } else {
      return $todo;
    }
  }
  
	/**
	 * Load all a user's todos, deleting any for issues that have been reassigned.
	 */
	public static function load_user_todos($zero = ">", $bas = 0, $haut = 100) {
		$result = \DB::table('projects_issues')
									->join('users_todos', 'users_todos.issue_id', '=', 'projects_issues.id')
									->join('projects', 'projects.id', '=', 'projects_issues.project_id')
									->where('assigned_to', '=', Auth::user()->id)
									->where('users_todos.weight', '>=', $bas)
									->where('users_todos.weight', '<', $haut)
									->where('projects_issues.status', $zero, 0)
									->order_by('projects_issues.status', 'DESC')
									->order_by('projects_issues.updated_at', 'DESC')
									->get(['projects_issues.id','projects_issues.status','projects_issues.title','users_todos.weight','projects.name', 'projects_issues.project_id']);
 		return $result;
	}
  
	/**
	* Load a todo
	* 
	* @param int       $task_id
	* @return array
	*/
	public static function load_todo_extras(&$todo) {
		// We need the issue and project names for display, status and 
   	// assigned_to for validity.
		$issue = Project\Issue::find($todo->issue_id);
		if (!empty($issue)) {
	      $todo->assigned_to  = $issue->attributes['assigned_to'];
	      $todo->issue_name   = $issue->attributes['title'];
	      $todo->issue_status = $issue->attributes['status'];
	      $todo->issue_link   = $issue->to();
	      
	      $project = Project::find($issue->attributes['project_id']);
	      $todo->project_name = $project->attributes['name'];
	      $todo->project_link = $project->to();
		} else {		// If issue has been deleted, force deletion of todo.
	      $todo->assigned_to  = 0;
	      $todo->issue_status = 0;
		}
	}
  
	/**
	* Add a new todo
	*
	* @param int       $user_id
	* @param int       $issue_id
	* @return array
	*/
	public static function add_todo($issue_id = 0, $status = 3, $weight = 0) {
		$user_id = Auth::user()->id;
		
		// Ensure user is assigned to issue.
	    	$issue = Project\Issue::load_issue($issue_id);
	    	if(empty($issue) || $issue->assigned_to !== $user_id) {
		     return array(
		     'success' => FALSE,
		     'errors' => __('smallbugs.todos_err_add'),
		     );
		}
		
		// Ensure issue is not already a task.
		$count = Todo::where('issue_id', '=', $issue_id)->where('user_id', '=', $user_id)->count();
		if ($count > 0) {
			return array(
			'success' => FALSE,
			'errors' => __('smallbugs.todos_err_already'),
			);
	    }
		//More default values passed since nov 2016
		$todo = new Todo;
		$todo->user_id  = $user_id;
		$todo->issue_id = $issue_id;
		$todo->status   = 3;
		$todo->weight   = $weight;
		$todo->created_at = date("Y-m-d H:m:s");
    	$todo->save();

    return array(
      'success' => TRUE,
    );
	}
  
	/**
	* Delete a todo
	*
	* @param int       $user_id
	* @param int       $task_id
	* @return array
	*/
	public static function remove_todo($issue_id = 0)
	{
    $user_id = Auth::user()->id;
    
    $todo = Todo::load_todo($issue_id, $user_id);
    if(!$todo)
		{
			return array(
				'success' => FALSE,
				'errors' => __('smallbugs.todos_err_loadfailed'),
			);
		}

		$todo->delete($todo);
    
		return array(
			'success' => TRUE
		);
	}
  
	/**
	* Update a todo
	*
	* @param int       $user_id
	* @param int       $issue_id
	* @return array
	*/
	public static function update_todo($issue_id = 0, $new_status = 1) {
		$user_id = Auth::user()->id;
		 
		$todo = Todo::load_todo($issue_id, $user_id);
		if(!$todo) {
			return array(
			'success' => FALSE,
			'errors' => __('smallbugs.todos_err_loadfailed'),
			);
		}
		
		// Sanity check on status value.
		// @TODO Handle N configurable status codes
		$new_status = (int)$new_status;
		if ($new_status >= 0 && $new_status <= 3) {
			$todo->status = $new_status;
			$todo->save();
			
			// Close issue if todo is moved to closed lane. 
			if ($new_status != 0) {
				$config_app = require path('public') . 'config.app.php';
				$Moyenne = ($config_app['Percent'][$new_status] + $config_app['Percent'][$new_status + 1]) / 2;
				$todo->weight = $Moyenne;
				$todo->updated_at = date("Y-m-d H:i:s");
				$todo->save();
			}
			$issue = Project\Issue::find($issue_id);
			if (!empty($issue)) { $issue->change_status($new_status); }
			return array('success' => TRUE);
		} else {
			return array(
			'success' => FALSE,
			'errors' => __('smallbugs.todos_err_update'),
			);
		}
	}
}
