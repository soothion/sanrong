<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {

    public $password;
    public $rememberMe;
    public $verifyCode;
    private $_identity;
    public $email;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('email,password,verifyCode', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            array('email', 'email'),
            // password needs to be authenticated
            array('password', 'authenticate'),
            array('verifyCode', 'captcha'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'email' => '邮箱',
            'password' => '密码',
            'verifyCode' => '验证码',
            'rememberMe' => 'Remember me next time',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->email, $this->password);
            if (!$this->_identity->authenticate()) {
//                if ($this->_identity->errorCode == 'checking') {
//                    Yii::app()->controller->showError('企业审核中');
//                }
                //$this->addError('password','用户名或者密码错误.');
                Yii::app()->controller->showError('用户名或者密码错误');
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->email, $this->password);
            $this->_identity->authenticate();
        }

        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
    }

}
