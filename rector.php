<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
	$rectorConfig->paths([
		__DIR__ . '/src',
	]);

	$rectorConfig->rule(LocallyCalledStaticMethodToNonStaticRector::class);

	$rectorConfig->sets([
		LevelSetList::UP_TO_PHP_85,
		SetList::CODE_QUALITY,
		SetList::CODING_STYLE,
		SetList::DEAD_CODE,
		SetList::EARLY_RETURN,
		SetList::TYPE_DECLARATION,
	]);
};
