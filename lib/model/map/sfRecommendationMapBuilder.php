<?php



class sfRecommendationMapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelActAsRecommendableBehaviorPlugin.lib.model.map.sfRecommendationMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_recommendation');
		$tMap->setPhpName('sfRecommendation');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('RECOMMENDABLE_MODEL', 'RecommendableModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('RECOMMENDABLE_ID', 'RecommendableId', 'string', CreoleTypes::VARCHAR, true, 32);

		$tMap->addColumn('SCORE', 'Score', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 