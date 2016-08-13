<?php

/**
 * Базовый класс формы
 *
 * @author Ivanov Andrey
 *
*/

abstract class FormBase
{
	protected $formName;	//Код формы, например "feedbackForm"
	protected $formTitle;	//Имя формы, например "Заказать звонок"
	protected $fields;		//Массив объектов классов наследников FieldBase (или просто массив полей)
	protected $response;	//Ответ в виде массива
	protected $useCaptcha;		//Используется ли капча? (true / false)
	
	/**
	* Конструктор
	*
	* @param string $formName код формы, например "feedbackForm"
	* @param string $formTitle имя формы, например "Заказать звонок"
	* @param array $fields Массив полей)
	* @param string $OKmessage сообщение об успешной отправки формы (например "спасибо за сообщение, наш оператор свяжется с вами")
	* @param boolean $useCaptcha Используется ли капча?
	*
	*/
	
	public function __construct($formName, $formTitle, $fields, $OKmessage, $useCaptcha)
	{
		$this->fields = $fields;
		$this->formName = $formName;
		$this->formTitle = $formTitle;
		$this->response["OKmessage"] = $OKmessage;
		$this->useCaptcha = $useCaptcha;
		$this->response["useCaptcha"] = $useCaptcha;
		if($useCaptcha)
		{
			$this->fields[] = new FieldCaptcha("", "captcha_word", "Капча",  true, false);
		}
	}
	
	public function getUseCaptcha()
	{
		return $this->useCaptcha;
	}
	
	/** 
	* Проверяет и отправляет форму
	*
	*/
	
	public function checkAndSubmit()
	{
		$this->response['success'] = true;
			$this->checkForm();		//Валидация
		if($this->response['success'])
			$this->saveForm();		//Сохранение в БД
		if($this->response['success'])
			$this->sendMail();		//Отправка по почте
		return($this->response);
	}
	
	/**
	* Получает поле по имени или false
	*
	* @param string $fieldName Имя поля
	*
	* @return mixed поле или flase
	*
	*/
	
	
	public function getFieldByName($fieldName)
	{
		foreach($this->fields as $field)
		{
			if($field->getFieldName() == $fieldName)
			{
				return $field;
			}
		}
		return false;
	}	
	
	/**
	* Задает значения полям
	*
	* @param array $arValues массив значений (с ключами FieldName)
	*
	*/
	
	public function setFieldsValues($arValues)
	{
		
		
		foreach($this->fields as &$field)
		{
			$field->setFieldValue($arValues[$field->getFieldName()]);
		}
		unset($field);
	}
	
	/** 
	* Устанавливает полю капчи флаг валидности
	*
	* @param boolean $captchaIsValid валидность капчи
	*
	*/
	
	
	public function setCaptchaIsValid($captchaIsValid)
	{
		foreach($this->fields as &$field)
		{
			if(get_class($field) == "FieldCaptcha")
			{
				$field->setCaptchaIsValid($captchaIsValid);
			}
		}
		unset($field);
	}
	
	/** 
	* Проверяет форму форму
	*
	*/
	
	
	protected function checkForm()	
	{
		foreach ($this->fields as $field)
		{
			if(!$field->isValid())
			{
				$this->response['success'] = false;
				$this->response['error_fields'][$field->getFieldName()] = $field->getMessage();
				
			}
		}
	}
		
	/** 
	* Сохраняет форму в бд форму
	*
	*/
	
	abstract protected function saveForm();	//Сохранение формы
	
	/** 
	* Отправляет форму
	*
	*/
	
	abstract protected function sendMail();	//Отправка формы
}