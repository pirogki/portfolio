<?php


/**
 * Базовый класс поля
 *
 * @author Ivanov Andrey
 *
*/

class FieldBase 
{
	protected $fieldName;	//Параметр "name" В input (например "email")
	protected $fieldTitle;	//Название поля (например "Адрес электронно почты")
	protected $message;		//Сообщение
	protected $fieldValue;	//Значение поля (например "asdf@asdf.ru")
	protected $impt;		//Обязательное ли поле? (true/false)

	/**
	* Конструктор
	*
	* @param string $fieldValue Значение поля
	* @param string $fieldName Параметр "name" В input
	* @param string $fieldTitle Название поля
	* @param boolean $impt Обязательное ли поле?
	*
	*/
	
	public function __construct($fieldValue, $fieldName, $fieldTitle, $impt) {
		$this->fieldValue = $fieldValue;	
		$this->fieldName = $fieldName; 
		$this->fieldTitle = $fieldTitle; 
		$this->impt = $impt; 
	}
	
	/**
	* Проверяет валидное ли значение поле
	*
	* @return boolean валидность
	*
	*/
	
	public function isValid()	
	{
		if($this->fieldValue)
		{
			return($this->isValidWhenExists());//Если поле заполнено проверяем на валидность
		}
		else
		{
			if($this->impt)
			{
				$this->message = "Поле \"" . $this->fieldTitle . "\" не заполнено";
			}
			return !$this->impt; //Если поле не заполнено: true - если поле не обязательное, false - если поле обязательное.
		}
	}
	
	/**
	* Проверяет валидность если поле заполнено
	*
	* @return boolean валидность
	*
	*/
	
	protected function isValidWhenExists()//функция, которая вызывается в случае если поле не пустое
	{
		return true;
	}
	
	/**
	* Получает информационное сообщение (об ошибке)
	*
	* @return string сообщение
	*
	*/
	
	public function getMessage() 
	{
		return $this->message;
	}
	
	/**
	* Получает имя поля
	*
	* @return string имя
	*
	*/
	
	public function getFieldName() 
	{
		return $this->fieldName;
	}
	
	/**
	* Получает подпись поля
	*
	* @return string подпись
	*
	*/
	
	public function getFieldTitle() 
	{
		return $this->fieldTitle;
	}
	
	/**
	* Получает значение поля
	*
	* @return string значение
	*
	*/
	
	public function getFieldValue() 
	{
		return $this->fieldValue;
	}
	
	/**
	* Задает значение поля
	*
	* @param string $fieldValue Значение поля
	* 
	*/
	
	public function setFieldValue($fieldValue) 
	{
		$this->fieldValue = $fieldValue;
	}
}

