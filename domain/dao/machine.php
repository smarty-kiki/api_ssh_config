<?php

class machine_dao extends dao
{
    protected $table_name = 'machine';
    protected $db_config_key = 'default';

    /* generated code start */
    public function find_by_register_key($register_key)
    {/*{{{*/
        return $this->find_by_column([
            'register_key' => $register_key,
        ]);
    }/*}}}*/
    /* generated code end */
}
