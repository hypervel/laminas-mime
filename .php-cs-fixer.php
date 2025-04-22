<?php

declare(strict_types=1);
/**
 * This file is part of huangdijia/laminas-mime-double.
 *
 * @link     https://github.com/huangdijia/laminas-mime-double
 * @document https://github.com/huangdijia/laminas-mime-double/blob/main/README.md
 * @contact  Huang Dijia <huangdijia@gmail.com>
 */
use Huangdijia\PhpCsFixer\Config;
use PhpCsFixer\Runner\Parallel\ParallelConfig;

require __DIR__ . '/vendor/autoload.php';

return (new Config())
    ->setParallelConfig(new ParallelConfig(4, 20))
    ->setHeaderComment(
        projectName: 'huangdijia/laminas-mime-double',
        projectLink: 'https://github.com/huangdijia/laminas-mime-double',
        projectDocument: 'https://github.com/huangdijia/laminas-mime-double/blob/main/README.md',
        contacts: [
            'Huang Dijia' => 'huangdijia@gmail.com',
        ],
    )
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('public')
            ->exclude('runtime')
            ->exclude('vendor')
            ->in(__DIR__)
            ->append([
                __FILE__,
            ])
    )
    ->setUsingCache(false);
