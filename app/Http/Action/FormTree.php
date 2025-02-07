<?php

namespace App\Http\Action;

class FormTree
{
    private function removeEmptyChildren(array $nodes): array
    {
        foreach ($nodes as &$node) {
            if (isset($node['children'])) {
                if (empty($node['children'])) {
                    unset($node['children']);
                } else {
                    $node['children'] = $this->removeEmptyChildren($node['children']);
                }
            }
        }
        return $nodes;
    }

    public function form(array $flatSections): array
    {
        $tree = [];
        $stack = [];

        foreach ($flatSections as $section) {
            $section['children'] = [];

            while (!empty($stack) and end($stack)['depth'] >= $section['depth']) {
                array_pop($stack);
            }

            if (empty($stack)) {
                $tree[] = $section;
                $stack[] = &$tree[count($tree) - 1];
            } else {
                $parent = &$stack[count($stack) - 1];
                $parent['children'][] = $section;

                $stack[] = &$parent['children'][count($parent['children']) - 1];
            }
        }

        return $this->removeEmptyChildren($tree);
    }
}
