<?php

  /**
   * Prints two forms, one for logging in with OpenID (default),
   * and one for logging in with a username and password.
   */

if ($session->flash()) {
    echo $session->flash();
 }

echo $html->tag('h2', 'Login');
if ($loggedIn) {
    echo 'Already logged in.';
 } else {
    // Create OpenID form components
    $oForm = $form->create('User', array('type' => 'post', 'action' => 'loginOpenid'));
    $oOpenid = $form->input('OpenidUrl.openid',
		      array('label' => false,
			    'div' => false,
			    'class' => 'loginTextbox'));
    $oSubmit = $form->submit('Login', array('div' => false, 'id' => 'UserLoginSubmitOpenid'));
    $oAuthenticating = $javascript->event('UserLoginForm',
					  'submit',
					  "Form.Element.setValue('UserLoginSubmitOpenid','Authenticating...');Form.Element.disable('UserLoginSubmitOpenid');");
    $oFocus = $javascript->codeBlock("Form.Element.focus('OpenidUrlOpenid');");
    $oEnd = $form->end();

    // Create traditional login components
    $lForm = $form->create('User', array('type' => 'post',
					 'action' => 'login',
					 'class' => 'login'));
    $lUsername = $form->input('username',
			      array('label' => 'Username:'));
    $lPassword = $form->input('password',
			      array('label' => 'Password:'));
    $lSubmit = $html->div(null,
			  $form->label(null, '') .
			  $form->submit('Login', array('div' => false, 'id' => 'UserLoginSubmit')));
    $lAuthenticating = $javascript->event('UserLoginForm',
				 'submit',
					  "Form.Element.setValue('UserLoginSubmit','Authenticating...');Form.Element.disable('UserLoginSubmit');");
    $lEnd = $form->end();

    echo $oForm . $oOpenid . $oSubmit . $oAuthenticating . $oFocus . $oEnd;
    echo $html->para(null,
		    'Don\'t have an <a href="http://openid.net/" target="_blank">OpenID</a>? Get one at <a href="https://www.myopenid.com/" target="_blank">myOpenID</a>.');
    echo $html->para(null,
		     'Or, if you want to login in a traditional way.');
    echo $lForm . $lUsername . $lPassword . $lSubmit . $lAuthenticating . $lEnd;

    echo $html->para(null,
		     "Don't have an account? " .
		     $ajax->link('Register',
				 array('controller' => 'users',
				       'action' => 'register')));
 }

?>