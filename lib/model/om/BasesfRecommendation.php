<?php


abstract class BasesfRecommendation extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $recommendable_model;


	
	protected $recommendable_id;


	
	protected $score;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getRecommendableModel()
	{

		return $this->recommendable_model;
	}

	
	public function getRecommendableId()
	{

		return $this->recommendable_id;
	}

	
	public function getScore()
	{

		return $this->score;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfRecommendationPeer::ID;
		}

	} 
	
	public function setRecommendableModel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->recommendable_model !== $v) {
			$this->recommendable_model = $v;
			$this->modifiedColumns[] = sfRecommendationPeer::RECOMMENDABLE_MODEL;
		}

	} 
	
	public function setRecommendableId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->recommendable_id !== $v) {
			$this->recommendable_id = $v;
			$this->modifiedColumns[] = sfRecommendationPeer::RECOMMENDABLE_ID;
		}

	} 
	
	public function setScore($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->score !== $v) {
			$this->score = $v;
			$this->modifiedColumns[] = sfRecommendationPeer::SCORE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->recommendable_model = $rs->getString($startcol + 1);

			$this->recommendable_id = $rs->getString($startcol + 2);

			$this->score = $rs->getInt($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfRecommendation object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfRecommendation:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfRecommendationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfRecommendationPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfRecommendation:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfRecommendation:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfRecommendationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfRecommendation:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfRecommendationPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfRecommendationPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = sfRecommendationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfRecommendationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getRecommendableModel();
				break;
			case 2:
				return $this->getRecommendableId();
				break;
			case 3:
				return $this->getScore();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfRecommendationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getRecommendableModel(),
			$keys[2] => $this->getRecommendableId(),
			$keys[3] => $this->getScore(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfRecommendationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setRecommendableModel($value);
				break;
			case 2:
				$this->setRecommendableId($value);
				break;
			case 3:
				$this->setScore($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfRecommendationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setRecommendableModel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setRecommendableId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setScore($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfRecommendationPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfRecommendationPeer::ID)) $criteria->add(sfRecommendationPeer::ID, $this->id);
		if ($this->isColumnModified(sfRecommendationPeer::RECOMMENDABLE_MODEL)) $criteria->add(sfRecommendationPeer::RECOMMENDABLE_MODEL, $this->recommendable_model);
		if ($this->isColumnModified(sfRecommendationPeer::RECOMMENDABLE_ID)) $criteria->add(sfRecommendationPeer::RECOMMENDABLE_ID, $this->recommendable_id);
		if ($this->isColumnModified(sfRecommendationPeer::SCORE)) $criteria->add(sfRecommendationPeer::SCORE, $this->score);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfRecommendationPeer::DATABASE_NAME);

		$criteria->add(sfRecommendationPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setRecommendableModel($this->recommendable_model);

		$copyObj->setRecommendableId($this->recommendable_id);

		$copyObj->setScore($this->score);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new sfRecommendationPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfRecommendation:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfRecommendation::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 