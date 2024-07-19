<?php

namespace App\Helpers;

class AhpHelper
{
    public static function calculateWeights($pairwiseComparisons)
    {
        $criteriaCount = count($pairwiseComparisons);
        $matrix = [];

        // Initialize the matrix with pairwise comparison values
        foreach ($pairwiseComparisons as $comparison) {
            $matrix[$comparison->criteria1_id][$comparison->criteria2_id] = $comparison->value;
            $matrix[$comparison->criteria2_id][$comparison->criteria1_id] = 1 / $comparison->value;
        }

        // Calculate sum of columns
        $columnSums = array_map(function($column) {
            return array_sum($column);
        }, array_transpose($matrix));

        // Normalize the matrix
        foreach ($matrix as $criteria1Id => &$row) {
            foreach ($row as $criteria2Id => &$value) {
                $value = $value / $columnSums[$criteria2Id];
            }
        }

        // Calculate the priority vector (average of rows)
        $priorityVector = array_map(function($row) {
            return array_sum($row) / count($row);
        }, $matrix);

        return $priorityVector;
    }
}

function array_transpose($array)
{
    return array_map(null, ...$array);
}
