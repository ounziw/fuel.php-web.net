<?php

class Controller_Methodlist extends Controller
{

	public function action_index()
	{
		return Response::forge($this->_index());
	}
	public function action_404()
	{
		return Response::forge($this->_index(),404);
	}
	function _index()
	{
		$view = View_Phptal::forge('methodlist/index');
		$view->set('title', 'クラス名検索');
		$white = new Classlist();
		$whiteclass = $white->getClassList();
		sort($whiteclass);
		$view->set('classdata', $whiteclass);
		$form = $this->_form();
		$view->set('html_form', $form->build('/methodlist/source'));
		$view->set('error_message', Session::get_flash('error_message'));
		return $view;
	}

	function _form()
	{
		$form = Fieldset::forge();
		$form->add('classname','クラス名')
			->add_rule('trim')
			->add_rule('valid_string',array('alpha','dashes'))
			->add_rule('required')
			->add_rule('max_length',30)
			;
		$form->add(Config::get('security.csrf_token_key'),'token',array('type'=>'hidden','value'=>Security::fetch_token())) ;
		$form->add('submit', '', array('type'=>'submit', 'value' => '検索', 'class'=>'btn btn-primary'));
		return $form;
	}

	public function action_list($classname)
	{
		try
		{
			$classname = ucfirst($classname);
			$whiteclass = new Classlist();
			if ( !in_array($classname,$whiteclass->getClassList()))
			{
				\Log::error(
					$classname .'Class Not in whitelist: '.
					\Input::uri().' '.
					\Input::ip().
					' "'.\Input::user_agent().'"'
				);
				throw new Exception('Invalid Request');
			}
				$form = $this->_form();
				$view = $this->_sourceview($classname);
				$view->set('html_form', $form->build('/methodlist/source'));
				return $view;
		}
		catch(Exception $e)
		{
			Session::set_flash('error_message', Security::xss_clean($e->getMessage()));	
			Response::redirect('');
		}
	}
	public function action_source()
	{
		// Security check is folked from: 
		// https://github.com/kenjis/sample-contact-form/blob/master/fuel/app/classes/controller/form.php
		try
		{
			if ( ! \Security::check_token())
			{
				\Log::error(
					'CSRF: '.
					\Input::uri().' '.
					\Input::ip().
					' "'.\Input::user_agent().'"'
				);
				throw new Exception('Invalid Request');
			}
			$form = $this->_form();
			$val  = $form->validation();
			$form->repopulate();
			if ($val->run())
			{
				$post = $val->validated();
				$classname = ucfirst($post['classname']);
				$view = $this->_sourceview($classname);
				$view->set('html_form', $form->build('/methodlist/source'));
				return $view;
			}
			else
			{
				throw new Exception('Invalid Input');
			}
		}
		catch(Exception $e)
		{
			Session::set_flash('error_message', Security::xss_clean($e->getMessage()));	
			Response::redirect('');
		}
	}
	function _sourceview($classname)
	{
		if ('' == $classname)
		{
			throw new InvalidArgumentException("No classname specified.");
		}
		$reflect = new SourceView($classname);
		$view = View_Phptal::forge('methodlist/source');
		$view->set('title', 'クラス名:' . $classname);
		$view->set('classname',$classname);
		$view->set('filename', $reflect->getFilename());
		$view->set('startline', $reflect->getStartLine());
		$view->set('endline', $reflect->getEndLine());
		$view->set('data', $reflect->getMethodStartEnd());
		$view->set('inheriteddata', $reflect->getInheritedMethods());
		$view->set('source', $reflect->outData('not-escape'));
		return $view;
	}
}
