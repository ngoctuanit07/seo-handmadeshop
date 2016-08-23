<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2015 Amasty (https://www.amasty.com)
 * @package Amasty_Xlanding
 */

    class Amasty_Xlanding_Model_Filter_Condition_Abstract extends Mage_SalesRule_Model_Rule_Condition_Product
    {
        public function correctOperator($operator, $inputType)
        {
            if ($inputType == 'category') {
                if ($operator == '==') {
                    $operator = '{}';
                } elseif ($operator == '!=') {
                    $operator = '!{}';
                }
            }
            return $operator;
        }
        
        public function getOperatorCondition($field, $operator, $value)
        {
            $result = ' true ';
            $adapter = Mage::getSingleton('core/resource')->getConnection(Mage_Core_Model_Resource::DEFAULT_READ_RESOURCE);
            
            switch ($operator) {
                case '!=':
                case '>=':
                case '<=':
                case '>':
                case '<':
                    $selectOperator = sprintf('%s?', $operator);
                    break;
                case '{}':
                case '!{}':
                    if (preg_match('/^.*(category_id)$/', $field) && is_array($value)) {
                        $selectOperator = ' IN (?)';
                    } else {
                        if (is_array($value)) {
                            $selectOperator = ' IN (?)';
                        } else {
                            $selectOperator = ' LIKE ?';
                            $value          = '%' . $value . '%';
                        }

                    }
                    if (substr($operator, 0, 1) == '!') {
                        $selectOperator = ' NOT' . $selectOperator;
                    }
                    break;

                case '()':
                    if (!is_array($value))
                        $value = $value = explode(', ', $value);

                    $selectOperator = ' IN(?)';
                    
                    break;

                case '!()':
                    if (!is_array($value))
                        $value = $value = explode(', ', $value);
                    
                    $selectOperator = ' NOT IN(?)';
                    break;

                default:
                    $selectOperator = '=?';
                    break;
            }
            $field = $adapter->quoteIdentifier($field);

            if (is_array($value) && in_array($operator, array('==', '!=', '>=', '<=', '>', '<'))) {
                $results = array();
                foreach ($value as $v) {
                    $results[] = $adapter->quoteInto("{$field}{$selectOperator}", $v);
                }
                $result = implode(' AND ', $results);
            } else {

                if ($this->getAttributeObject()->getFrontendInput() == 'multiselect' &&
                    in_array($operator, array('()', '!()', '{}', '!{}', '[]', '![]'))){

                    if (is_array($value)) {
                        $resultArr = array();

                        foreach($value as $option){
                            $condition = in_array($operator, array('()', '{}', '[]')) ? ' <> 0' : ' = 0';

                            $resultArr[] = $adapter->quoteInto("FIND_IN_SET(?, {$field}) {$condition}", $option);
                        }

                        if (count($resultArr) > 0){
                            if (in_array($operator, array('()', '!{}', '![]'))) {
                                $result = "(" . implode(' OR ', $resultArr) . ")";
                            } else {
                                $result = "(" . implode(' AND ', $resultArr) . ")";
                            }

                        }
                    }
                } else {
                    $result = $adapter->quoteInto("{$field}{$selectOperator}", $value);
                }


            }


            return $result;
        }

    
    }
?>