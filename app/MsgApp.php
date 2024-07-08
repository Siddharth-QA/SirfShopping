<?php

namespace App;

class MsgApp
{
    const AGENT = 'Agent';
    const LINK_CUSTOMER = 'customer';

    const ADMIN = 'Admin';
    const LINK_ADMIN = 'admin';
    const SETTING = 'setting';

    /** Validation Start */
    const EMAIL = 'required|email';
    const MOBILE = 'required|regex:/^\+?[0-9]{1,3}([0-9]\s?){9,15}$/';
    const VAL_MOB = 'required|regex:/^[6-9][0-9]{9}$/';
    const VAL_CODE_MOB = 'required|regex:/^\+[1-9]{1}[0-9]{3,14}$/';
    const VAL_NAME = 'required|between:3,50|regex:/^[&a-zA-Z\s]+$/';
    const DR_NAME = 'required|between:3,50|regex:/^[&a-zA-Z .\-]+$/';
    const VAL_UNAME = 'required|between:3,50|regex:/^[&a-zA-Z0-9\s]+$/|unique:tableName';
    const VAL_NAME_NUM = 'required|between:3,50|regex:/^[a-zA-Z0-9_\s]*$/';
    const FILE_IMF_NULL = 'nullable|mimes:jpeg,png,jpg|max:10240';
    const TAX = 'required|between:0,99.99';
    const FILE_IMF = 'required|mimes:jpeg,png,jpg|max:10240';
    const VAL_ADDRESS = 'required|regex:/^[#.0-9a-zA-Z\s,-\/]+$/';
    const NULL_ADDRESS = 'nullable|regex:/^[#.0-9a-zA-Z\s,-\/]+$/';
    const VAL_PIN = 'required|regex:/^[1-9][0-9]{5}$/';
    const REQ_EXISTS = 'required|exists:tableName,id';
    const REQ_EXISTS_NULL = 'nullable|exists:tableName,id';
    const VAL_INT = 'required|integer';
    const FILE_PATH = 'upload/';
    const TABLE_NAME = 'tableName';
    const DATE_TIME = 'required|regex:/^([0-9]{4}/[0-1][0-9]/[0-3][0-9])\s([0-1][0-9]|[2][0-3]):([0-5][0-9]))$/';
    const REQ = 'required';
    /** Validation End */
    const INVALID_MESSAGE = ':attribute is invalid.';

    const SUCCESS_ADDED = 'Record Added Successfully';
    const SUCCESS_UPD = 'Record Updated Successfully';
    const SUCCESS_DEL = 'Record Delete Successfully';
    const UN_ASSESS = 'Unauthorized Access';
}
