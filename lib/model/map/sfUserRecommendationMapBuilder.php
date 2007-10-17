<?php



class sfUserRecommendationMapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelActAsRecommendableBehaviorPlugin.lib.model.map.sfUserRecommendationMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('sf_user_recommendation');
		$tMap->setPhpName('sfUserRecommendation');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('RECOMMENDABLE_MODEL', 'RecommendableModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('RECOMMENDABLE_ID', 'RecommendableId', 'string', CreoleTypes::VARCHAR, true, 32);

		$tMap->addForeignKey('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, 'sf_guard_user', 'ID', false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 