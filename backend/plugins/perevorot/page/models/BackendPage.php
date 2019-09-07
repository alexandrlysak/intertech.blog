<?php namespace Perevorot\Page\Models;

use Model;
use DbDongle;

class BackendPage extends Model
{
    use \October\Rain\Database\Traits\NestedTree;

    use \Perevorot\Page\Traits\PageByMenuTrait;
    use \Perevorot\Page\Traits\PageModelMutators;

    const PAGE_TYPE_STATIC=1;
    const PAGE_TYPE_ALIAS=2;
    const PAGE_TYPE_EXTERNAL=3;
    const PAGE_TYPE_ROUTE=4;

    public $table = 'perevorot_page_page';

    public $belongsTo = [
        'menu' => ['Perevorot\Page\Models\Menu', 'key'=>'menu_id'],
        'alias_page' => ['Perevorot\Page\Models\Page', 'key'=>'alias_page_id'],
    ];

    public function performMove($node, $target, $position)
    {
        list($a, $b, $c, $d) = $this->getSortedBoundaries($node, $target, $position);

        $connection = $node->getConnection();
        $grammar = $connection->getQueryGrammar();
        $pdo = $connection->getPdo();

        $parentId = ($position == 'child')
            ? $target->getKey()
            : $target->getParentId();

        if ($parentId === null) {
            $parentId = 'NULL';
        }
        else {
            $parentId = $pdo->quote($parentId);
        }

        $currentId = $pdo->quote($node->getKey());
        $leftColumn = $node->getLeftColumnName();
        $rightColumn = $node->getRightColumnName();
        $parentColumn = $node->getParentColumnName();
        $wrappedLeft = $grammar->wrap($leftColumn);
        $wrappedRight = $grammar->wrap($rightColumn);
        $wrappedParent = $grammar->wrap($parentColumn);
        $wrappedId = DbDongle::cast($grammar->wrap($node->getKeyName()), 'TEXT');

        $leftSql = "CASE
            WHEN $wrappedLeft BETWEEN $a AND $b THEN $wrappedLeft + $d - $b
            WHEN $wrappedLeft BETWEEN $c AND $d THEN $wrappedLeft + $a - $c
            ELSE $wrappedLeft END";

        $rightSql = "CASE
            WHEN $wrappedRight BETWEEN $a AND $b THEN $wrappedRight + $d - $b
            WHEN $wrappedRight BETWEEN $c AND $d THEN $wrappedRight + $a - $c
            ELSE $wrappedRight END";

        $parentSql = "CASE
            WHEN $wrappedId = $currentId THEN $parentId
            ELSE $wrappedParent END";

        $result = $node->newQuery()
            ->where(function($query) use ($leftColumn, $rightColumn, $a, $d) {
                $query
                    ->whereBetween($leftColumn, [$a, $d])
                    ->orWhereBetween($rightColumn, [$a, $d])
                ;
            })
            ->where('menu_id', $this->menu_id)
            ->update([
                $leftColumn => $connection->raw($leftSql),
                $rightColumn => $connection->raw($rightSql),
                $parentColumn => $connection->raw($parentSql)
            ])
        ;

        return $result;
    }
}