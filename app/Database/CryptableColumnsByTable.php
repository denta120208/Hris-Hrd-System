<?php

namespace App\Database;

class CryptableColumnsByTable
{
    public static function decryptableColumnsByTable() {
        return [
            'employee' => [
                'emp_lastname',
                'emp_firstname',
                'emp_middle_name',
                'emp_ktp',
                'emp_street1',
                'city_code',
                'coun_code',
                'provin_code',
                'emp_zipcode',
                'emp_street2',
                'city_code_res',
                'provin_code_res',
                'emp_zipcode_res',
                'emp_hm_telephone',
                'emp_mobile',
                'emp_work_telephone',
                'emp_work_email',
                'npwp',
                'emp_fullname',
                'firstname',
                'middle_name',
                'lastname',
                'pic_firstname',
                'pic_middle_name',
                'pic_lastname'
            ],
            'emp_appraisal' => [
                'appraisal_value',
                'hrd_value',
                'total_value'
            ],
            'emp_appraisal_deleted' => [
                'appraisal_value',
                'hrd_value'
            ],
            'emp_appraisal_value' => [
                'emp_value',
                'sup_value',
                'dir_value',
                'hrd_value',
                'final_value',
                'nilai_awal'
            ],
            'emp_appraisal_value_deleted' => [
                'emp_value',
                'sup_value',
                'dir_value',
                'hrd_value',
                'final_value'
            ],
            'emp_appraisal_value_historical' => [
                'value_angka',
                'value_huruf',
                'value_box9'
            ],
            'emp_appraisal_evaluator' => [
                'appraisal_value'
            ],
            'emp_appraisal_evaluator_deleted' => [
                'appraisal_value'
            ]
        ];
    }

    public static function encryptableColumnsByTable() {
        return [
            'employee' => [
                'emp_lastname',
                'emp_firstname',
                'emp_middle_name',
                'emp_ktp',
                'emp_street1',
                'city_code',
                'coun_code',
                'provin_code',
                'emp_zipcode',
                'emp_street2',
                'city_code_res',
                'provin_code_res',
                'emp_zipcode_res',
                'emp_hm_telephone',
                'emp_mobile',
                'emp_work_telephone',
                'emp_work_email',
                'npwp',
                'emp_fullname',
            ],
            'emp_appraisal' => [
                'appraisal_value',
                'hrd_value',
                'total_value'
            ],
            'emp_appraisal_deleted' => [
                'appraisal_value',
                'hrd_value'
            ],
            'emp_appraisal_value' => [
                'emp_value',
                'sup_value',
                'dir_value',
                'hrd_value',
                'final_value',
                'nilai_awal'
            ],
            'emp_appraisal_value_deleted' => [
                'emp_value',
                'sup_value',
                'dir_value',
                'hrd_value',
                'final_value'
            ],
            'emp_appraisal_value_historical' => [
                'value_angka',
                'value_huruf',
                'value_box9'
            ],
            'emp_appraisal_evaluator' => [
                'appraisal_value'
            ],
            'emp_appraisal_evaluator_deleted' => [
                'appraisal_value'
            ]
        ];
    }
}
