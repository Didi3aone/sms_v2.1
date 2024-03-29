<?php if (!defined("BASEPATH")) exit('No direct script access allowed');


class Sms_model extends CI_Model {

    protected $_table = '';
    protected $_table_alias = '';
    protected $_pk_field = '';

    public function __construct() {
        parent::__construct();
    }

    public function set_model($table_name = null, $table_alias = null, $table_pk = null) {
        $this->_table = $table_name;
        $this->_table_alias = $table_alias;
        $this->_pk_field = $table_pk;

        return $this;
    }

    /**
    * function for get all data
    * return @param array
    * author : didi
    * copyright : digistyles.com
    */
    public function get_all_data($params = array())
    {
        //default values.
        (isset($params["select"])) ? $select = $params["select"] : $select = "*";
        (isset($params["status"])) ? $status = $params["status"] : $status = STATUS_ALL;
        (isset($params["order_by"])) ? $orderBy = $params["order_by"] : $orderBy = array($this->_pk_field => "asc");
        (isset($params["find_by_pk"])) ? $findByPK = $params["find_by_pk"]: $findByPK = array();
        (isset($params["limit"])) ? $limit = $params["limit"] : $limit = 0;
        (isset($params["start"])) ? $start = $params["start"] : $start = 0;
        (isset($params["conditions"])) ? $conditions = $params["conditions"] : $conditions = "";
        (isset($params["conditions_or"])) ? $conditions_or = $params["conditions_or"] : $conditions_or = "";
        (isset($params["filter"])) ? $filter = $params["filter"] : $filter = array();
        (isset($params["filter_or"])) ? $filter_or = $params["filter_or"] : $filter_or = array();
        (isset($params["row_array"])) ? $row_array = $params["row_array"] : $row_array = false;
        (isset($params["count_all_first"])) ? $count_all_first = $params["count_all_first"] : $count_all_first = false;
        (isset($params["joined"])) ? $joined = $params["joined"] : $joined = null;
        (isset($params["left_joined"])) ? $left_joined = $params["left_joined"] : $left_joined = null;
        (isset($params["from"])) ? $from = $params["from"] : $from = $this->_table." ".$this->_table_alias;
        (isset($params["group_by"])) ? $group_by = $params["group_by"] : $group_by = null;
        (isset($params["debug"])) ? $debug = $params["debug"] : $debug = false;
        (isset($params["distinct"])) ? $distinct = $params["distinct"] : $distinct = false;

        $this->db->select($select);

        //for search for PK "id" as array.
        if (count($findByPK) > 0) {
            $this->db->where_in($this->_pk_field, $findByPK);
        }

        if ($distinct !== false) {
            $this->db->distinct();
        }

        //for where conditions.
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        if (!empty($conditions_or)) {
            $this->db->group_start();
            $this->db->or_where($conditions_or);
            $this->db->group_end();
        }

        //for filters.
        if (is_array($filter) && count($filter) > 0) {
            $this->db->group_start();
            $keys = array_keys($filter);
            for ($i = 0; $i < count($keys); $i++) {
                $column = $keys[$i];
                $value = $filter[$keys[$i]];
                $this->db->like($column, $value);
            }
            $this->db->group_end();
        }
        //or filters.
        if (is_array($filter_or) && count($filter_or) > 0) {
            $this->db->group_start();
            $keys = array_keys($filter_or);
            for ($i = 0; $i < count($keys); $i++) {
                $column = $keys[$i];
                $value = $filter_or[$keys[$i]];
                if ($i == 0) {
                    $this->db->like($column, $value);
                } else {
                    $this->db->or_like($column, $value);
                }
            }
            $this->db->group_end();
        }

        if ($orderBy != false) {
            //for ordering.
            foreach ($orderBy as $column => $order) {
                $this->db->order_by($column, $order);
            }
        }

        //for join table.
        if ($joined != null) {
            foreach ($joined as $table_name => $connector) {
                $this->db->join($table_name, key($connector)." = ".$connector[key($connector)]);
            }
        }

        //for left joined table.
        if ($left_joined != null) {
            foreach ($left_joined as $table_name => $connector) {
                $this->db->join($table_name, key($connector)." = ".$connector[key($connector)], "left");
            }
        }

        //for group by
        if ($group_by != null) {
            $this->db->group_by($group_by);
        }

        //before adding limit and start, count all first.
        if ($count_all_first) {
            $result['total'] = $this->db->count_all_results($from, false);
        } else {
            $result['total'] = 0;
            $this->db->from($from);
        }

        //limit and start.
        $this->db->limit($limit, $start);

        //debug.
        if ($debug) {
            pq($this->db);exit;
        }

        //decide if the result is a single row or array of rows.
        if ($row_array === true) {
            $result['datas'] = $this->_get_row();
        } else {
            $result['datas'] = $this->_get_array();
        }

        //return it.
        return $result;
    }

    /**
     * this function is for private use only, to get query result as a single row only.
     */
    protected function _get_row()
    {
        $result = $this->db->get()->row_array();

        return $result;
    }

    /**
     * this function is for private use only, to get query result as array.
     */
    protected function _get_array()
    {
        $result = $this->db->get()->result_array();
        return $result;
    }

    /**
     * function insert.
     * @param $is_batch if you want to insert as batches.
     */
    public function insert($datas, $extra_param = array())
    {
        (isset($extra_param["is_batch"])) ? $is_batch = $extra_param["is_batch"] : $is_batch = false;
        //default values.
        if (!$is_batch) {

            $this->db->insert($this->_table, $datas);
            $id = $this->db->insert_id();
            return $id;

        } else {

            //insert batch.
            $num_inserted = $this->db->insert_batch($this->_table, $datas);
            return $num_inserted;
        }

    }

    /**
     * function update
     */
    public function update($datas, $condition, $extra_param = array())
    {
        return $this->db->update($this->_table, $datas, $condition);
    }

    /**
     * function delete
     */
    public function delete($condition, $extra_param = array())
    {
        //default values.
        (isset($extra_param["is_permanent"])) ? $is_permanent = $extra_param["is_permanent"] : $is_permanent = false;

        if (!$is_permanent) {
            //delete just change status.
            $datas = array(
                'is_active' => STATUS_DELETE,
            );
            return $this->db->update($this->_table, $datas, $condition);
        } else {
            //delete will delete row permanently.
            return $this->db->delete($this->_table, $condition);
        }
    }

    public function get_no_broadcast( $id = null)
    {
        $data = [];

        $this->db->select("tnd.UserMobilePhone");
        $this->db->from("tbl_sms_group tsg");
        $this->db->join("mst_data_user tnd", "tnd.UserGroupId = tsg.group_id","left");
        $this->db->where("tsg.group_id", $id);
        // $this->db->group_by("tsg.group_id");
        $res = $this->db->get();
        // echo $this->db->last_query();
        if( $res->num_rows() > 0) {
            foreach( $res->result_array() as $key => $rows) {
                $data[$key] = $rows;
            }
        }
        return $data;
    }
 
    function get_chat($no)
    {
        $this->db->select(
            "ix.*,
            si.SenderFrom as pengirim, 
            ix.SenderNumber as penerima,
            ix.ReceivingDateTime as tgl_pengirim , 
            si.InsertIntoDB as tgl_penerima, 
            si.TextDecoded as pesan_pengirim, 
            ix.TextDecoded as pesan_penerima"
        );
        $this->db->from("inbox ix");
        $this->db->join("sentitems si","si.DestinationNumber = ix.SenderNumber","left");
        $this->db->where("
            (ix.SenderNumber = '".$no."' AND si.SenderFrom= '08979392113' OR ix.SenderNumber = '".$no."' AND si.SenderFrom= '08979392113')
        ");
        $this->db->order_by("ix.ReceivingDateTime","desc");
        $res = $this->db->get();

        return $res->result_array();
    }

    public function get_conv_chat( $no )
    {
        $query = "SELECT *
            FROM (SELECT
                    `ID`,
                    `DestinationNumber`  AS `Number`,
                    `SendingDateTime`    AS `Time`,
                    `TextDecoded`        AS `Pesan`, 
                    IF (`StatusError`='-1', 'Me', 'Pengirim') AS `Folder` /* Standar Database Gammu StatusError nilainya pasti '-1' */
                  FROM `sentitems`
                  WHERE `DestinationNumber` = '$no'
                  UNION 
                  SELECT
                `ID`,
                    `SenderNumber`,
                    `ReceivingDateTime`,
                    `TextDecoded`, IF (`SenderNumber` <> '-1', 'Pengirim', 'Me') AS `Folder` /* Field bebass, yang penting nilainya tidak '-1' */
                  FROM `inbox`
                  WHERE `SenderNumber` = '$no') a
            ORDER BY TIME DESC;";
        $result = $this->db->query($query)->result_array();
        return $result;
    }
}
