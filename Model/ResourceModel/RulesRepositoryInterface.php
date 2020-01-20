<?php

interface RulesRepositoryInterface{
    public function load($ruleId);
    public function save(\Magenest\Rules\Model\ResourceModel\Rule $rule);
    public function delete(\Magenest\Rules\Model\ResourceModel\Rule $rule);
}