<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class SearchForm extends Form
{
    protected function _buildSchema(Schema $schema) :Schema
    {
        return $schema
            ->addField('keyword', ['type' => 'string']);
    }
}
