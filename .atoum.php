<?php
//.atoum.php

use mageekguy\atoum;
use mageekguy\atoum\reports;


$stdOutWriter = new atoum\writers\std\out();

$coveralls = new reports\asynchronous\coveralls('src', 'URuIeb1VklQC4lyITAg4ByKFYuDvFINOg');
$defaultFinder = $coveralls->getBranchFinder();
$coveralls
        ->setBranchFinder(function() use ($defaultFinder) {
                if (($branch = getenv('TRAVIS_BRANCH')) === false)
                {
                        $branch = $defaultFinder();
                }

                return $branch;
        })
        ->setServiceName(getenv('TRAVIS') ? 'travis-ci' : null)
        ->setServiceJobId(getenv('TRAVIS_JOB_ID') ?: null)
        ->addWriter($stdOutWriter);

$runner->addReport($coveralls);

$script->addDefaultReport();

?>
