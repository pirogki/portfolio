<?php
class FieldCaptcha extends FieldBase
{
	//Тут передаем бонусное поле captchaIsValid. Не удалось заставить работать $APPLICATION->CaptchaCheckCode (bitrix метод) в методе класса
	protected $captchaIsValid; //Валидна ли капча?
	
	/**
	* Конструктор
	*
	* @param string $fieldValue Значение поля
	* @param string $fieldName Параметр "name" В input
	* @param string $fieldTitle Название поля
	* @param boolean $impt Обязательное ли поле?
	* @param boolean $captchaIsValid Валидная ли капча?
	*
	*/
	
	public function __construct($fieldValue, $fieldName, $fieldTitle, $impt, $captchaIsValid) {
		parent::__construct($fieldValue, $fieldName, $fieldTitle, $impt);
		$this->captchaIsValid = $captchaIsValid;
	}
	
	/** 
	* Устанавливает полю капчи флаг валидности
	*
	* @param boolean $captchaIsValid валидность капчи
	*
	*/
	
	public function setCaptchaIsValid($captchaIsValid)
	{
		$this->captchaIsValid = $captchaIsValid;
	}
	
	/**
	* Проверяет валидность если поле заполнено
	*
	* @return boolean валидность
	*
	*/
	
	protected function isValidWhenExists()	
	{
		//global $APPLICATION;
		//if(!$APPLICATION->CaptchaCheckCode($_REQUEST["captcha_word"], $_REQUEST["captcha_sid"]))
		if (!$this->captchaIsValid)
		{
			$this->message = "Неверный код капчи";
			return false;
		}
		else
		{
			return true;
		}
		
	}
}