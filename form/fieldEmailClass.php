<?php

/** 
* Класс валидации мыла
*
* @author Ivanov Andrey
*
*/
class FieldEmail extends FieldBase
{
	
	/**
	* Проверяет валидность если поле заполнено
	*
	* @return boolean валидность
	*
	*/
	
	protected function isValidWhenExists()	
	{
		if (!preg_match ("/^[^@]+@[^@\.]+\.[^@\.]+$/", $this->fieldValue))
		{
			$this->message = "Поле \"" . $this->fieldTitle . "\" заполнено не корректно.";
			return false;
		}
		else
		{
			return true;
		}
		
	}
}