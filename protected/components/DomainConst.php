<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomainConst
 *
 * @author NguyenPT
 */
class DomainConst {
    //-----------------------------------------------------
    // Domain constants
    //-----------------------------------------------------
    /** String value "0" */
    const NUMBER_ZERO_VALUE                             = '0';
    /** String value "1" */
    const NUMBER_ONE_VALUE                              = '1';
    /** String value "2" */
    const NUMBER_TWO_VALUE                              = '2';
    /** Constant of Status: Active */
    const DEFAULT_STATUS_ACTIVE                         = DomainConst::NUMBER_ONE_VALUE;
    /** Constant of Status: Inactive */
    const DEFAULT_STATUS_INACTIVE                       = DomainConst::NUMBER_ZERO_VALUE;
    /** Constant of Gender: Male */
    const GENDER_MALE                                   = DomainConst::NUMBER_ONE_VALUE;
    /** Constant of Gender: Female */
    const GENDER_FEMALE                                 = DomainConst::NUMBER_TWO_VALUE;
    /** Constant of Gender: Other */
    const GENDER_OTHER                                  = DomainConst::NUMBER_ZERO_VALUE;
    /** Constant of Access status: Allow */
    const DEFAULT_ACCESS_ALLOW                          = DomainConst::NUMBER_ONE_VALUE;  
    /** Constant of Access status: Deny */
    const DEFAULT_ACCESS_DENY                           = DomainConst::NUMBER_ZERO_VALUE;
    /** Constant of Checkbox status: CHECKED */
    const CHECKBOX_STATUS_CHECKED                       = DomainConst::NUMBER_ONE_VALUE;
    /** Constant of Checkbox status: UNCHECKED */
    const CHECKBOX_STATUS_UNCHECKED                     = DomainConst::NUMBER_ZERO_VALUE;
    /** Default value of parent id: 0 */
    const DEFAULT_PARENT_VALUE                          = DomainConst::NUMBER_ZERO_VALUE;
    /** API Response status: Failed */
    const API_RESPONSE_STATUS_FAILED                    = 0;
    /** API Response status: Success */
    const API_RESPONSE_STATUS_SUCCESS                   = 1;
    /** API Response code: Bad request */
    const API_RESPONSE_CODE_BAD_REQUEST                 = 400;
    /** API Response code: Success */
    const API_RESPONSE_CODE_SUCCESS                     = 200;
    /** API Response code: Unauthorized */
    const API_RESPONSE_CODE_UNAUTHORIZED                = 401;
    
    /** Platform flag */
    const PLATFORM_IOS                                  = 0;
    const PLATFORM_ANDROID                              = 1;
    const PLATFORM_WINDOW                               = 2;
    const PLATFORM_WEB                                  = 3;
    
    /** Constant of splitter */
    const SPLITTER_TYPE_1                               = ', ';
    const SPLITTER_TYPE_2                               = ',';
    const SPLITTER_TYPE_3                               = '-';
    const SPLITTER_TYPE_4                               = '.';
    const SPLITTER_TYPE_MONEY                           = self::SPLITTER_TYPE_2;
    /** Html space */
    const SPACE                                         = '&nbsp;';
    /** Date format */
    const DATE_FORMAT_1                                 = 'Y-m-d H:i:s';
    /** Date format */
    const DATE_FORMAT_2                                 = 'dd/mm/yy';
    /** Date format */
    const DATE_FORMAT_3                                 = 'd/m/Y';
    /** Date format */
    const DATE_FORMAT_4                                 = 'Y-m-d';
    /** Date format */
    const DATE_FORMAT_5                                 = 'd \t\h\g m\, Y';
    /** Date format */
    const DATE_FORMAT_6                                 = 'Y/m/d';
    /** Date format */
    const DATE_FORMAT_7                                 = 'Y/m/d H:i:s';
    /** Date format */
    const DATE_FORMAT_8                                 = 'H:i\, d \t\h\g m\, Y';
    /** Date format */
    const DATE_FORMAT_9                                 = 'YmdHis';
    /** Date format */
    const DATE_FORMAT_10                                = 'Ymd';
    /** Date format */
    const DATE_FORMAT_11                                = 'd/m/Y H:i';
    /** Date format */
    const DATE_FORMAT_12                                = 'yy-mm-dd';
    /** Date format */
    const DATE_FORMAT_13                                = 'm/Y';
    /** Date format */
    const DATE_FORMAT_14                                = 'mm/yy';
    /** Date format */
    const DATE_FORMAT_15                                = 'yy';
    /** Date format */
    const DATE_FORMAT_16                                = 'ddmmyyyy';
    /** Date default value null */
    const DATE_DEFAULT_NULL                             = '0000-00-00';
    /** Date default value null */
    const DATE_DEFAULT_NULL_FULL                        = '0000-00-00 00:00:00';
    /** Date default value null */
    const DATE_FORMAT_3_NULL                            = '00/00/0000';
    /** Date default year value null */
    const DATE_DEFAULT_YEAR_NULL                        = '0000';
    /** Date format main */
    const DATE_FORMAT_VIEW                              = self::DATE_FORMAT_5;
    /** Date format backend */
    const DATE_FORMAT_BACK_END                          = self::DATE_FORMAT_3;
    /** Date format db */
    const DATE_FORMAT_DB                                = self::DATE_FORMAT_4;
    /** Date format */
    const DEFAULT_TIMEZONE                              = 'Asia/Ho_Chi_Minh';
    /** Default IP address */
    const DEFAULT_IP_ADDRESS                            = '192.168.1.1';
    /** Minimum length of password */
    const PASSW_LENGTH_MIN                              = 6;
    /** Maximum length of password */
    const PASSW_LENGTH_MAX                              = 50;
    /** Prefix of store card id string */
    const STORE_CARD_ID_PREFIX                          = 'TK';
    /** Prefix of order id string */
    const ORDER_ID_PREFIX                               = 'ĐH';
    /** Prefix of customer id string */
    const CUSTOMER_ID_PREFIX                            = 'BN';
    /** Prefix of medical record id string */
    const MEDICAL_RECORD_ID_PREFIX                      = 'HS';
    /** Prefix of receipt id string */
    const RECEIPT_ID_PREFIX                             = 'PT';
    /** Prefix of refer code id string */
    const REFER_CODE_ID_PREFIX                          = 'QR';
    /** Website domain */
    const CONTENT_WEBSITE                               = 'http://nhakhoavietmy.com.vn';
    /** Website name */
    const CONTENT_AGENT                                 = 'NHA KHOA VIỆT MỸ';
    
    /** Editor width */
    const EDITOR_WIDTH                                  = '800px';
    /** Editor height */
    const EDITOR_HEIGHT                                 = '500px';
    
    //-----------------------------------------------------
    // Keys setting 
    //-----------------------------------------------------
    /** Token */
    const KEY_TOKEN                         = 'token';
    /** Keyword */
    const KEY_KEYWORD                       = 'keyword';
    /** Q */
    const KEY_ROOT_REQUEST                  = 'q';
    /** Notify Id */
    const KEY_NOTIFY_ID                     = 'notify_id';
    /** Type */
    const KEY_TYPE                          = 'type';
    /** Object Id */
    const KEY_OBJECT_ID                     = 'obj_id';
    /** Issue Id */
    const KEY_ISSUE_ID                      = 'issue_id';
    /** Customer Id */
    const KEY_CUSTOMER_ID                   = 'customer_id';
    /** Customer Name */
    const KEY_CUSTOMER_NAME                 = 'customer_name';
    /** Customer Address */
    const KEY_CUSTOMER_ADDRESS              = 'customer_address';
    /** Customer Agent */
    const KEY_CUSTOMER_AGENT                = 'customer_agent';
    /** Customer Agent */
    const KEY_CUSTOMER_AGENT_DELIVERY       = 'customer_delivery_agent';
    /** Customer Agent */
    const KEY_CUSTOMER_AGENT_DELIVERY_ID    = 'customer_delivery_agent_id';
    /** Customer Phone */
    const KEY_CUSTOMER_PHONE                = 'customer_phone';
    /** Customer contact */
    const KEY_CUSTOMER_CONTACT              = 'customer_contact';
    /** Title */
    const KEY_TITLE                         = 'title';
    /** Message */
    const KEY_MESSAGE                       = 'message';
    /** Problem */
    const KEY_PROBLEM                       = 'problem';
    /** Page */
    const KEY_PAGE                          = 'page';
    /** Chief monitor id */
    const KEY_CHIEF_MONITOR_ID              = 'chief_monitor_id';
    /** Monitor agent id */
    const KEY_MONITOR_AGENT_ID              = 'monitor_agent_id';
    /** Accounting id */
    const KEY_ACCOUNTING_ID                 = 'accounting_id';
    /** Username */
    const KEY_USERNAME                      = 'username';
    /** Password */
    const KEY_PASSWORD                      = 'password';
    /** GCM device token */
    const KEY_GCM_DEVICE_TOKEN              = 'gcm_device_token';
    /** APNS device token */
    const KEY_APNS_DEVICE_TOKEN             = 'apns_device_token';
    /** News Id */
    const KEY_NEWS_ID                       = 'news_id';
    /** Device phone */
    const KEY_DEVICE_PHONE                  = 'device_phone';
    /** Id */
    const KEY_ID                            = 'id';
    /** Note Customer */
    const KEY_NOTE_CUSTOMER                 = 'note_customer';
    /** qty_12 */
    const KEY_QTY_12                        = 'qty_12';
    /** qty_50 */
    const KEY_QTY_50                        = 'qty_50';
    /** qty_12_list */
    const KEY_QTY_12_LIST                   = 'qty_12_list';
    /** qty_50_list */
    const KEY_QTY_50_LIST                   = 'qty_50_list';
    /** Phone */
    const KEY_PHONE                         = 'phone';
    /** Password */
    const KEY_PASSWORD_CONFIRM              = 'password_confirm';
    /** First name */
    const KEY_FIRST_NAME                    = 'first_name';
    /** Province Id */
    const KEY_PROVINCE_ID                   = 'province_id';
    /** District Id */
    const KEY_DISTRICT_ID                   = 'district_id';
    /** Ward Id */
    const KEY_WARD_ID                       = 'ward_id';
    /** Street id */
    const KEY_STREET_ID                     = 'street_id';
    /** Street */
    const KEY_STREET                        = 'street';
    /** House Number */
    const KEY_HOUSE_NUMBER                  = 'house_numbers';
    /** Sign up code */
    const KEY_SIGN_UP_CODE                  = 'signup_code';
    /** Employee Id */
    const KEY_EMPLOYEE_ID                   = 'employee_id';
    /** Employee Name */
    const KEY_EMPLOYEE_NAME                 = 'employee_name';
    /** Employee phone */
    const KEY_EMPLOYEE_PHONE                = 'employee_phone';
    /** Employee code */
    const KEY_EMPLOYEE_CODE                 = 'employee_code';
    /** Employee image */
    const KEY_EMPLOYEE_IMG                  = 'employee_image';
    /** Uphold type */
    const KEY_UPHOLD_TYPE                   = 'type_uphold';
    /** Uphold type */
    const KEY_UPHOLD_TYPE_IDX               = 'uphold_type';
    /** Content */
    const KEY_CONTENT                       = 'content';
    /** Contact person */
    const KEY_CONTACT_PERSON                = 'contact_person';
    /** Contact telephone number */
    const KEY_CONTACT_TEL                   = 'contact_tel';
    /** Status */
    const KEY_STATUS                        = 'status';
    /** Status number */
    const KEY_STATUS_NUMBER                 = 'status_number';
    /** start_date */
    const KEY_START_DATE                    = 'start_date';
    /** start_date */
    const KEY_END_DATE                      = 'end_date';
    /** diagnosis */
    const KEY_DIAGNOSIS                     = 'diagnosis';
    /** diagnosis_id */
    const KEY_DIAGNOSIS_ID                  = 'diagnosis_id';
    /** diagnosis_other_id */
    const KEY_DIAGNOSIS_OTHER_ID            = 'diagnosis_other_id';
    /** teeth */
    const KEY_TEETH                         = 'teeth';
    /** timer */
    const KEY_TIMER                         = 'timer';
    /** treatment */
    const KEY_TREATMENT                     = 'treatment';
    /** pathological */
    const KEY_PATHOLOGICAL                  = 'pathological';
    /** pathological_id */
    const KEY_PATHOLOGICAL_ID               = 'pathological_id';
    /** status_treatment */
    const KEY_STATUS_TREATMENT              = 'status_treatment';
    /** status_treatment_detail */
    const KEY_STATUS_TREATMENT_DETAIL       = 'status_treatment_detail';
    /** status_treatment_process */
    const KEY_STATUS_TREATMENT_PROCESS      = 'status_treatment_process';
    /** Status of receipt */
    const KEY_STATUS_RECEIPT                = 'status_receipt';
    /** address_config */
    const KEY_ADDRESS_CONFIG                = 'address_config';
    /** doctor */
    const KEY_DOCTOR                        = 'doctor';
    /** doctor_id */
    const KEY_DOCTOR_ID                     = 'doctor_id';
    /** customer_confirm */
    const KEY_CUSTOMER_CONFIRM              = 'customer_confirm';
    /** receiptionist_id */
    const KEY_RECEIPTIONIST_ID              = 'receiptionist_id';
    /** schedule_id */
    const KEY_SCHEDULE_ID                   = 'schedule_id';
    /** teeth_id */
    const KEY_TEETH_ID                      = 'teeth_id';
    /** treatment_type_id */
    const KEY_TREATMENT_TYPE_ID             = 'treatment_type_id';
    /** healthy */
    const KEY_HEALTHY                       = 'healthy';
    /** can_update */
    const KEY_CAN_UPDATE                    = 'can_update';
    /** Uphold Id */
    const KEY_UPHOLD_ID                     = 'uphold_id';
    /** Hours handle */
    const KEY_HOURS_HANDLE                  = 'hours_handle';
    /** Contact phone */
    const KEY_CONTACT_PHONE                 = 'contact_phone';
    /** Contact */
    const KEY_CONTACT                       = 'contact';
    /** Contact note */
    const KEY_CONTACT_NOTE                  = 'contact_note';
    /** Note */
    const KEY_NOTE                          = 'note';
    /** Report wrong */
    const KEY_REPORT_WRONG                  = 'report_wrong';
    /** Report revenue */
    const KEY_REPORT_REVENUE                = 'report_revenue';
    /** Note internal */
    const KEY_NOTE_INTERNAL                 = 'note_internal';
    /** Reply Id */
    const KEY_REPLY_ID                      = 'reply_id';
    /** Old password */
    const KEY_OLD_PASSWORD                  = 'old_password';
    /** New password */
    const KEY_NEW_PASSWORD                  = 'new_password';
    /** New password confirm */
    const KEY_NEW_PASSWORD_CONFIRM          = 'new_password_confirm';
    /** Code */
    const KEY_CODE                          = 'code';
    /** Record */
    const KEY_RECORD                        = 'record';
    /** Record number */
    const KEY_RECORD_NUMBER                 = 'record_number';
    /** Notify count text */
    const KEY_NOTIFY_COUNT_TEXT             = 'NotifyCountText';
    /** Issue create */
    const KEY_ISSUE_CREATE                  = 'issue_create';
    /** Total page */
    const KEY_TOTAL_PAGE                    = 'total_page';
    /** Total quantity */
    const KEY_TOTAL_QTY                     = 'total_qty';
    /** Promotion amount */
    const KEY_PROMOTION_AMOUNT              = 'promotion_amount';
    /** Discount amount */
    const KEY_DISCOUNT_AMOUNT               = 'discount_amount';
    /** Total */
    const KEY_TOTAL                         = 'total';
    /** List */
    const KEY_LIST                          = 'list';
    /** LIST_CHIEF_MONITOR */
    const KEY_LIST_CHIEF_MONITOR            = 'LIST_CHIEF_MONITOR';
    /** LIST_MONITOR_AGENT */
    const KEY_LIST_MONITOR_AGENT            = 'LIST_MONITOR_AGENT';
    /** LIST_ACCOUNTING */
    const KEY_LIST_ACCOUNTING               = 'LIST_ACCOUNTING';
    /** Model issue */
    const KEY_MODEL_ISSUE                   = 'model_issue';
    /** Menu */
    const KEY_MENU                          = 'menu';
    /** Data uphold */
    const KEY_DATA_UPHOLD                   = 'data_uphold';
    /** Maximum upload size */
    const KEY_MAX_UPLOAD                    = 'max_upload';
    /** Data issue */
    const KEY_DATA_ISSUE                    = 'data_issue';
    /** Role id */
    const KEY_ROLE_ID                       = 'role_id';
    /** User id */
    const KEY_USER_ID                       = 'user_id';
    /** User name */
    const KEY_USER_NAME                     = 'user_name';
    /** owner_id */
    const KEY_OWNER_ID                      = 'owner_id';
    /** owner_name */
    const KEY_OWNER_NAME                    = 'owner_name';
    /** User information */
    const KEY_USER_INFO                     = 'user_info';
    /** Check menu */
    const KEY_CHECK_MENU                    = 'check_menu';
    /** Province list */
    const KEY_PROVINCE_LIST                 = 'province_list';
    /** District list */
    const KEY_DISTRICT_LIST                 = 'district_list';
    /** Ward list */
    const KEY_WARD_LIST                     = 'ward_list';
    /** Detail id */
    const KEY_DETAIL_ID                     = 'detail_id';
    /** QR code */
    const KEY_QR                            = 'qr';
    /** details */
    const KEY_DETAILS                       = 'details';
    /** Model uphold */
    const KEY_MODEL_UPHOLD                  = 'model_uphold';
    /** Address */
    const KEY_ADDRESS                       = 'address';
    /** Address */
    const KEY_GOOGLE_ADDRESS                = 'google_address';
    /** Image avatar */
    const KEY_IMG_AVATAR                    = 'image_avatar';
    /** Notify type */
    const KEY_NOTIFY_TYPE                   = 'notify_type';
    /** Request type */
    const KEY_REQUEST_TYPE                  = 'request_by';
    /** Request type */
    const KEY_RATING_STATUS                 = 'rating_status';
    /** Request type */
    const KEY_RATING_TYPE                   = 'rating_type';
    /** Request type */
    const KEY_RATING_NOTE                   = 'rating_note';
    /** Other information */
    const KEY_OTHER_INFO                    = 'OtherInfo';
    /** Key category */
    const KEY_CATEGORY                      = 'category';
    /** Key object_id */
    const KEY_OBJECT_ID_NEW                 = 'object_id';
    /** Uphold last id */
    const KEY_UPHOLD_ID_LASTEST             = 'uphold_id_lastest';
    /** Need change pass */
    const KEY_NEED_CHANGE_PASS              = 'need_change_pass';
    /** Need update app */
    const KEY_NEED_UPDATE_APP               = 'need_update_app';
    /** Detail reply id */
    const KEY_DETAIL_REPLY_ID               = 'detail_reply_id';
    /** Uphold create */
    const KEY_UPHOLD_CREATE                 = 'uphold_create';
    /** Role name */
    const KEY_ROLE_NAME                     = 'role_name';
    /** List streets */
    const KEY_LIST_STREET                   = 'list_street';
    /** List agents */
    const KEY_LIST_AGENT                    = 'list_agent';
    /** List hgd type */
    const KEY_LIST_HGD_TYPE                 = 'list_hgd_type';
    /** List hgd_invest */
    const KEY_LIST_HGD_INVEST               = 'list_hgd_invest';
    /** Name */
    const KEY_NAME                          = 'name';
    /** Gender */
    const KEY_GENDER                        = 'gender';
    /** Age */
    const KEY_AGE                           = 'age';
    /** Data */
    const KEY_DATA                          = 'data';
    /** Key transaction id */
    const KEY_TRANSACTION_ID                = 'transaction_id';
    /** Key transaction key */
    const KEY_TRANSACTION_KEY               = 'transaction_key';
    /** Key transaction type */
    const KEY_TRANSACTION_TYPE              = 'transaction_type';
    /** Grand total */
    const KEY_GRAND_TOTAL                   = 'grand_total';
    /** Setting key: is login */
    const KEY_SETTING_IS_LOGGING            = 'gasservice.isLogin';
    /** Setting key: user token */
    const KEY_SETTING_USER_TOKEN            = 'gasservice.user.token';
    /** Setting key: orderVipDescription */
    const KEY_SETTING_ORDER_VIP_DESCRIPTION = 'gasservice.order.orderVipDescription';
    /** Setting key: training mode */
    const KEY_SETTING_TRAINING_MODE         = 'gasservice.trainningMode';
    /** Setting key: Transaction id */
    const KEY_SETTING_TRANSACTION_ID        = 'gasservice.transaction.id';
    /** Setting key: Transaction key */
    const KEY_SETTING_TRANSACTION_KEY       = 'gasservice.transaction.key';
    /** Setting key: Temp token */
    const KEY_SETTING_TEMP_TOKEN            = 'gasservice.temp.token';
    /** Setting key: Debug color */
    const KEY_SETTING_DEBUG_COLOR           = 'gasservice.debug.color';
    /** Setting key: Debug toast */
    const KEY_SETTING_DEBUG_TOAST           = 'gasservice.debug.toast';
    /** Setting key: Debug zoom */
    const KEY_SETTING_DEBUG_ZOOM            = 'gasservice.debug.zoom';
    /** Setting key: Debug Is Gas service */
    const KEY_SETTING_DEBUG_IS_GAS_SERVICE  = 'gasservice.debug.isGasService';
    /** Setting key: Debug Is Show number picker */
    const KEY_SETTING_DEBUG_IS_SHOW_NUM_PICKER  = 'gasservice.debug.isShowNumPicker';
    /** Setting key: Debug Is Show number picker */
    const KEY_SETTING_DEBUG_IS_SHOW_TOP_ICON    = 'gasservice.debug.isShowTopIcon';
    /** Setting key: Debug Flag use material_name or material_name_short */
    const KEY_SETTING_DEBUG_IS_USE_MATERIAL_NAME_SHORT    = 'gasservice.debug.isUseMaterialNameShort';
    /** Setting key: List gas information */
    const KEY_LIST_GAS_INFORMATION          = 'gasservice.listGasInfo';
    /** Setting key: Role id */
    const KEY_SETTING_ROLE_ID               = 'gasservice.roleId';
    /** Setting key: Material type id */
    const KEY_MATERIALS_TYPE_ID             = 'materials_type_id';
    /** Setting key: Material id */
    const KEY_MATERIALS_ID                  = 'materials_id';
    /** Setting key: Material name */
    const KEY_MATERIALS_NAME                = 'materials_name';
    /** Setting key: Material no */
    const KEY_MATERIALS_NO                  = 'materials_no';
    /** Setting key: Material short name */
    const KEY_MATERIALS_NAME_SHORT          = 'materials_name_short';
    /** Setting key: Material price */
    const KEY_MATERIALS_PRICE               = 'material_price';
    /** Setting key: Price */
    const KEY_PRICE                         = 'price';
    /** Setting key: Quantity */
    const KEY_QUANTITY                      = 'qty';
    /** Setting key: Real quantity */
    const KEY_QUANTITY_REAL                 = 'qty_real';
    /** Setting key: Serial */
    const KEY_SERI                          = 'seri';
    /** Setting key: Serial */
    const KEY_SERIAL                        = 'serial';
    /** Setting key: KEY_KG_EMPTY */
    const KEY_KG_EMPTY                      = 'kg_empty';
    /** Setting key: KEY_KG_HAS_GAS */
    const KEY_KG_HAS_GAS                    = 'kg_has_gas';
    /** Setting key: Amount */
    const KEY_AMOUNT                        = 'amount';
    /** Setting key: Material image */
    const KEY_MATERIAL_IMAGE                = 'material_image';
    /** Setting key: Email */
    const KEY_EMAIL                         = 'email';
    /** Setting key: Subject */
    const KEY_SUBJECT                       = 'subject';
    /** Setting key: View */
    const KEY_VIEW                          = 'view';
    /** Setting key: Params */
    const KEY_PARAMS                        = 'params';
    /** Setting key: To */
    const KEY_TO                            = 'to';
    /** Setting key: From */
    const KEY_FROM                          = 'from';
    /** Setting key: Attachment */
    const KEY_ATTACHMENT                    = 'attachment';
    /** Setting key: Host */
    const KEY_HOST                          = 'host';
    /** Setting key: Port */
    const KEY_PORT                          = 'port';
    /** Setting key: Encryption */
    const KEY_ENCRYPTION                    = 'encryption';
    /** Career */
    const KEY_CAREER                        = 'career';
    /** Characteristics */
    const KEY_CHARACTERISTICS               = 'characteristics';
    /** medical_history */
    const KEY_MEDICAL_HISTORY               = 'medical_history';
    /** Setting key: Agent */
    const KEY_AGENT                         = 'agent';
    /** Setting key: Agent id */
    const KEY_AGENT_ID                      = 'agent_id';
    /** Setting key: Agent name */
    const KEY_AGENT_NAME                    = 'agent_name';
    /** Setting key: Agent phone */
    const KEY_AGENT_PHONE                   = 'agent_phone';
    /** Setting key: Agent cell phone */
    const KEY_AGENT_CELL_PHONE              = 'agent_cell_phone';
    /** Setting key: Agent phone support */
    const KEY_AGENT_PHONE_SUPPORT           = 'agent_phone_support';
    /** Setting key: Agent address */
    const KEY_AGENT_ADDRESS                 = 'agent_address';
    /** Setting key: Agent latitude */
    const KEY_AGENT_LAT                     = 'agent_latitude';
    /** Setting key: Agent longitude */
    const KEY_AGENT_LONG                    = 'agent_longitude';
    /** Setting key: Agent list */
    const KEY_AGENT_LIST                    = 'agent_list';
    /** Setting key: Daily report status */
    const KEY_DAILY_REPORT_STATUS           = 'daily_report_status';
    /** Setting key: Information of agent */
    const KEY_INFO_AGENT                    = 'info_agent';
    /** Setting key: Information of gas */
    const KEY_INFO_GAS                      = 'info_gas';
    /** Setting key: Information of price */
    const KEY_INFO_PRICE                    = 'info_price';
    /** Setting key: Information of promotion */
    const KEY_INFO_PROMOTION                = 'info_promotion';
    /** Setting key: Distance 1 */
    const KEY_DISTANCE_1                    = 'distance_1';
    /** Setting key: Distance 2 */
    const KEY_DISTANCE_2                    = 'distance_2';
    /** Setting key: Allow update */
    const KEY_ALLOW_UPDATE                  = 'allow_update';
    /** Setting key: Order type */
    const KEY_ORDER_TYPE                    = 'order_type';
    /** Setting key: Type amount */
    const KEY_TYPE_AMOUNT                   = 'type_amount';
    /** Setting key: Amount discount */
    const KEY_AMOUNT_DISCOUNT               = 'amount_discount';
    /** Setting key: Discount type */
    const KEY_DISCOUNT_TYPE                 = 'discount_type';
    /** Setting key: Status cancel */
    const KEY_STATUS_CANCEL                 = 'status_cancel';
    /** Setting key: Order detail */
    const KEY_ORDER_DETAIL                  = 'order_detail';
    /** Setting key: Customer info */
    const KEY_CUSTOMER_INFO                 = 'customer_info';
    /** Setting key: Boss name */
    const KEY_BOSS_NAME                     = 'boss_name';
    /** Setting key: Boss phone */
    const KEY_BOSS_PHONE                    = 'boss_phone';
    /** Setting key: Manager name */
    const KEY_MANAGER_NAME                  = 'manage_name';
    /** Setting key: Manager phone */
    const KEY_MANAGER_PHONE                 = 'manage_phone';
    /** Setting key: Technical name */
    const KEY_TECHNICAL_NAME                = 'technical_name';
    /** Setting key: Technical phone */
    const KEY_TECHNICAL_PHONE               = 'technical_phone';
    /** Birthday */
    const KEY_BIRTH_DAY                     = 'birthday';
    
    /** Key total record */
    const KEY_TOTAL_RECORD                  = 'total_record';
    /** Code no */
    const KEY_CODE_NO                       = 'code_no';
    /** Level type */
    const KEY_LEVEL_TYPE                    = 'level_type';
    /** Created date */
    const KEY_CREATED_DATE                  = 'created_date';
    /** Created byte */
    const KEY_CREATED_BY                    = 'created_by';
    /** Sale name */
    const KEY_SALE_NAME                     = 'sale_name';
    /** Sale phone */
    const KEY_SALE_PHONE                    = 'sale_phone';
    /** Sale type */
    const KEY_SALE_TYPE                     = 'sale_type';
    /** Schedule month */
    const KEY_SCHEDULE_MONTH                = 'schedule_month';
    /** Last reply message */
    const KEY_LAST_REPLY_MESSAGE            = 'last_reply_message';
    /** Schedule Type */
    const KEY_SCHEDULE_TYPE                 = 'schedule_type';
    /** Uid login */
    const KEY_UID_LOGIN                     = 'uid_login';
    /** Date time handle */
    const KEY_DATE_TIME_HANDLE              = 'date_time_handle';
    /** Reply item */
    const KEY_REPLY_ITEM                    = 'reply_item';
    /** Image thumb */
    const KEY_IMG_THUMB                     = 'thumb';
    /** Image large */
    const KEY_IMG_LARGE                     = 'large';
    /** Image list */
    const KEY_IMAGES                        = 'images';
    /** Image */
    const KEY_IMAGE                         = 'image';
    /** Latitude */
    const KEY_LATITUDE                      = 'latitude';
    /** Version code */
    const KEY_VERSION_CODE                  = 'version_code';
    /** Longitude */
    const KEY_LONGITUDE                     = 'longitude';
    /** Uphold list */
    const KEY_UPHOLD_LIST                   = 'uphold_list';
    /** Uphold rating */
    const KEY_UPHOLD_RATING                 = 'uphold_rating';
    /** Version code */
    const KEY_APP_VERSION_CODE              = 'app_version_code';
    /** Confirm code */
    const KEY_CONFIRM_CODE                  = 'confirm_code';
    /** show_nhan_giao_hang */
    const KEY_SHOW_NHAN_GH                  = 'show_nhan_giao_hang';
    /** show_huy_giao_hang */
    const KEY_SHOW_HUY_GH                   = 'show_huy_giao_hang';
    /** Transaction History Id */
    const KEY_TRANSACTION_HISTORY_ID        = 'transaction_history_id';
    /** Call center uphold */
    const KEY_CALL_CENTER_UPHOLD            = 'call_center_uphold';
    /** Hotline */
    const KEY_HOTLINE                       = 'hotline';
    /** Flag gas 24h */
    const KEY_FLAG_GAS_24H                  = 'app_type';
    /** Key text of order type */
    const KEY_ORDER_TYPE_TEXT               = 'order_type_text';
    /** Key amount of order type */
    const KEY_ORDER_TYPE_AMOUNT             = 'order_type_amount';
    /** Key amount of bu vo */
    const KEY_AMOUNT_BU_VO                  = 'amount_bu_vo';
    /** Key expiration date */
    const KEY_EXPIRY_DATE                   = 'expiry_date';
    /** Key b50 kg */
    const KEY_B50                           = 'b50';
    /** Key b45 kg */
    const KEY_B45                           = 'b45';
    /** Key b12 kg */
    const KEY_B12                           = 'b12';
    /** Key b6 kg */
    const KEY_B6                            = 'b6';
    /** Key Unit */
    const KEY_UNIT                          = 'unit';
    /** Key Delivery date */
    const KEY_DATE_DELIVERY                 = 'date_delivery';
    /** Key Total gas */
    const KEY_TOTAL_GAS                     = 'total_gas';
    /** Key Total gas du */
    const KEY_TOTAL_GAS_DU                  = 'total_gas_du';
    /** Key note of employee */
    const KEY_NOTE_EMPLOYEE                 = 'note_employee';
    /** Key Name of gas */
    const KEY_NAME_GAS                      = 'name_gas';
    /** Key name of driver */
    const KEY_NAME_DRIVER                   = 'name_driver';
    /** Key name of car */
    const KEY_NAME_CAR                      = 'name_car';
    /** Key name of maintain employee */
    const KEY_NAME_EMPLOYEE_MAINTAIN        = 'name_employee_maintain';
    /** Key Cylinder information */
    const KEY_INFO_CYLINDER                 = 'info_vo';
    /** Key Order id */
    const KEY_ORDER_ID                      = 'order_id';
    /** Key Buying */
    const KEY_BUYING                        = 'buying';
    /** Key Platform */
    const KEY_PLATFORM                      = 'platform';
    /** Key Date */
    const KEY_DATE                          = 'date';
    /** Key Date from */
    const KEY_DATE_FROM                     = 'date_from';
    /** Key Date to */
    const KEY_DATE_TO                       = 'date_to';
    /** Key Customer Family Brand*/
    const KEY_CUSTOMER_FAMILY_BRAND         = 'hgd_thuong_hieu';
    /** List Customer family type */
    const KEY_HGD_TYPE                      = 'hgd_type';
    /** List Customer family type */
    const KEY_HGD_TYPE_ID                   = 'hgd_type_id';
    /** List Customer family type */
    const KEY_HGD_TIME_USE                  = 'hgd_time_use';
    /** List Customer family type */
    const KEY_HGD_DOI_THU                   = 'hgd_doi_thu';
    /** Key customer type */
    const KEY_CUSTOMER_TYPE                 = 'customer_type';
    /** Key latitude longitude */
    const KEY_LONG_LAT                      = 'latitude_longitude';
    /** Key list_hgd_invest_text */
    const KEY_HGD_INVEST_TEXT               = 'list_hgd_invest_text';
    /** Key Can update flag */
    const KEY_CAN_UPDATE_FLAG               = 'can_update';
    /** Key full name */
    const KEY_FULL_NAME                     = 'full_name';
    /** Key Model record */
    const KEY_MODEL_RECORD                  = 'model_record';
    /** Key Report */
    const KEY_HGD_REPORT                    = 'hgd_short_report';
    /** Key Material cylinder */
    const KEY_MATERIAL_VO                   = 'material_vo';
    /** Key Material gas */
    const KEY_MATERIAL_GAS                  = 'material_gas';
    /** Key the other material */
    const KEY_MATERIAL_HGD                  = 'material_hgd';
    /** Key Cancel order reasons */
    const KEY_ORDER_STATUS_CANCEL           = 'order_status_cancel';
    /** Key List order type */
    const KEY_ORDER_LIST_TYPE               = 'order_list_type';
    /** Key List order discount type */
    const KEY_ORDER_LIST_DISCOUNT_TYPE      = 'order_list_discount_type';
    /** Key List order discount type */
    const KEY_STORECARD_STATUS_CANCEL       = 'storecard_status_cancel';
    /** Key Action type */
    const KEY_ACTION_TYPE                   = 'action_type';
    /** Key Change type */
    const KEY_CHANGE_TYPE                   = 'change_type';
    /** Key App order id */
    const KEY_APP_ORDER_ID                  = 'app_order_id';
    /** Key Type of store card */
    const KEY_TYPE_IN_OUT                   = 'type_in_out';
    /** Key List Types of store card */
    const KEY_LIST_TYPE_IN_OUT              = 'list_type_in_out';
    /** Key List all materials */
    const KEY_LIST_ALL_MATERIAl             = 'list_all_material';
    /** Key List all materials */
    const KEY_LIST_CASHBOOK_MATER_LOOKUP    = 'list_cashbook_master_lookup';
    /** Key Support type */
    const KEY_SUPPORT_ID                    = 'support_id';
    /** Key Support type */
    const KEY_SUPPORT_TEXT                  = 'support_text';
    /** Key favorite limit */
    const KEY_LIMIT_FAVORITE                = 'limit_favorite';
    /** Key Support type list */
    const KEY_LIST_SUPPORT_EMPLOYEE         = 'list_support_employee';
    /** Key show button complete flag */
    const KEY_SHOW_BUTTON_COMPLETE          = 'show_button_complete';
    /** Key show button save flag */
    const KEY_SHOW_BUTTON_SAVE              = 'show_button_save';
    /** Key setting */
    const KEY_TOTAL_GAS_DU_KG               = 'total_gas_du_kg';
    /** Key setting */
    const KEY_SHOW_THU_TIEN                 = 'show_thu_tien';
    /** Key setting */
    const KEY_SHOW_CHI_GAS_DU               = 'show_chi_gas_du';
    /** Key setting */
    const KEY_SHOW_BUTTON_DEBIT             = 'show_button_debit';
    /** Key setting */
    const KEY_PAY_DIRECT                    = 'pay_direct';
    /** Key setting */
    const KEY_SHOW_BUTTON_CANCEL            = 'show_button_cancel';
    /** Key setting */
    const KEY_LIST_ID_IMAGE                 = 'list_id_image';
    /** Key lookup type */
    const KEY_LOOKUP_TYPE                   = 'lookup_type';
    /** Key master lookup id */
    const KEY_MASTER_LOOKUP_ID              = 'master_lookup_id';
    /** Key master lookup text */
    const KEY_MASTER_LOOKUP_TEXT            = 'master_lookup_text';
    /** Key date input */
    const KEY_DATE_INPUT                    = 'date_input';
    /** Key lookup type text */
    const KEY_LOOKUP_TYPE_TEXT              = 'lookup_type_text';
    /** Key list images */
    const KEY_LIST_IMAGE                    = 'list_image';
    /** Key begin quantity */
    const KEY_BEGIN                         = 'begin';
    /** Key in quantity */
    const KEY_IN                            = 'in';
    /** Key out quantity */
    const KEY_OUT                           = 'out';
    /** Key end quantity */
    const KEY_END                           = 'end';
    /** Key rows */
    const KEY_ROWS                          = 'rows';
    /** Key allow_update_storecard_hgd */
    const KEY_ALLOW_UPDATE_STORECARD_HGD    = 'allow_update_storecard_hgd';
    /** Key next_time_update_storecard_hgd */
    const KEY_NEXT_UPDATE_STORECARD_HGD     = 'next_time_update_storecard_hgd';
    /** Setting key: discount */
    const KEY_DISCOUNT                      = 'discount';
    /** Setting key: debt */
    const KEY_DEBT                          = 'debt';
    /** Setting key: final */
    const KEY_FINAL                         = 'final';
    /** Key amount of bu vo */
    const KEY_BU_VO                         = 'bu_vo';
    /** Key amount of revenue */
    const KEY_REVENUE                       = 'revenue';
    /** Key sum all */
    const KEY_SUM_ALL                       = 'sum_all';
    /** Key sum order type */
    const KEY_SUM_ORDER_TYPE                = 'sum_order_type';
    /** Key total revenue */
    const KEY_TOTAL_REVENUE                 = 'total_revenue';
    /** Key opening balance */
    const KEY_OPENING_BALANCE               = 'opening_balance';
    /** Key ending balance */
    const KEY_ENDING_BALANCE                = 'ending_balance';
    /** Balance */
    const KEY_BALANCE                       = 'balance';
    /** Key report_inventory */
    const KEY_REPORT_INVENTORY              = 'report_inventory';
    /** Key report_hgd */
    const KEY_REPORT_ORDER_FAMILY           = 'report_hgd';
    /** Key report_cashbook */
    const KEY_REPORT_CASHBOOK               = 'report_cashbook';
    /** Key note of create */
    const KEY_NOTE_CREATE                   = 'note_create';
    /** show_confirm */
    const KEY_SHOW_CONFIRM                  = 'show_confirm';
    /** show_cancel */
    const KEY_SHOW_CANCEL                   = 'show_cancel';
    /** send_to_id */
    const KEY_SEND_TO_ID                    = 'send_to_id';
    /** name_user_reply */
    const KEY_NAME_USER_REPLY               = 'name_user_reply';
    /** position */
    const KEY_POSITION                      = 'position';
    /** name_user_to */
    const KEY_NAME_USER_TO                  = 'name_user_to';
    /** time_reply */
    const KEY_TIME_REPLY                    = 'time_reply';
    /** time */
    const KEY_TIME                          = 'time';
    /** time */
    const KEY_TIME_ID                       = 'time_id';
    /** can_close */
    const KEY_CAN_CLOSE                     = 'can_close';
    /** can_reply */
    const KEY_CAN_REPLY                     = 'can_reply';
    /** list_reply */
    const KEY_LIST_REPLY                    = 'list_reply';
    /** time_send */
    const KEY_TIME_SEND                     = 'time_send';
    /** created_date_on_history */
    const KEY_CREATED_DATE_ON_HISTORY       = 'created_date_on_history';
    /** isIncomming */
    const KEY_IS_INCOMMING                  = 'isIncomming';
    /** isIncommingName */
    const KEY_IS_INCOMMING_NAME             = 'isIncommingName';
    /** account_id */
    const KEY_ACCOUNT_ID                    = 'account_id';
    /** account_name */
    const KEY_ACCOUNT_NAME                  = 'account_name';
    /** action_date */
    const KEY_ACTION_DATE                   = 'action_date';
    /** description */
    const KEY_DESCRIPTION                   = 'description';
    /** Flag successUpdate */
    const KEY_SUCCESS_UPDATE                = 'successUpdate';
    /** Alias */
    const KEY_ALIAS                         = 'alias';
    /** Child Actions */
    const KEY_CHILD_ACTIONS                 = 'childActions';
    /** Childen key */
    const KEY_CHILDREN                      = 'children';
    /** Actions */
    const KEY_ACTIONS                       = 'actions';
    /** expression */
    const KEY_EXPRESSION                    = 'expression';
    /** Allow */
    const KEY_ALLOW                         = 'allow';
    /** Deny */
    const KEY_DENY                          = 'deny';
    /** JSON_FIELD */
    const KEY_JSON_FIELD                    = 'JSON_FIELD';
    /** json */
    const KEY_JSON                          = 'json';
    /** home */
    const KEY_HOME                          = 'home';
    /** account */
    const KEY_ACCOUNT                       = 'account';
    /** customer_list */
    const KEY_CUSTOMER_LIST                 = 'customer_list';
    /** daily_report */
    const KEY_DAILY_REPORT                  = 'daily_report';
    /** city_id */
    const KEY_CITY_ID                       = 'city_id';
    /** Submit */
    const KEY_SUBMIT                        = 'submit';
    /** Submit month */
    const KEY_SUBMIT_MONTH                  = 'submitMonth';
    /** Submit last month */
    const KEY_SUBMIT_LAST_MONTH             = 'submitLastMonth';
    /** Submit date before yesterday */
    const KEY_SUBMIT_DATE_BEFORE_YESTERDAY  = 'submitDateBeforeYesterday';
    /** Submit yesterday */
    const KEY_SUBMIT_DATE_YESTERDAY         = 'submitYesterday';
    /** Submit today */
    const KEY_SUBMIT_TODATE                 = 'submitToday';
    /** Submit save */
    const KEY_SUBMIT_SAVE                   = 'submitSave';
    /** Receipt */
    const KEY_RECEIPT                       = 'receipt';
    /** Submit excel     */
    const KEY_SUBMIT_EXCEL                  = 'submitExcel';
    /** Right content */
    const KEY_RIGHT_CONTENT                 = 'rightContent';
    /** Info schedule */
    const KEY_INFO_SCHEDULE                 = 'infoSchedule';
    /** Ajax */
    const KEY_AJAX                          = 'ajax';
    /** Setting key: Can select agent */
    const KEY_CAN_SELECT_AGENT              = 'canSelectAgent';
    /** Setting key: List receipts */
    const KEY_LIST_RECEIPTS                 = 'listReceipts';
    /** Setting key: month */
    const KEY_MONTH                         = 'month';
    
    //-----------------------------------------------------
    // List domain const
    //-----------------------------------------------------
    /** Block UI color */
    const BLOCK_UI_COLOR                    = '#fff';
    
    //-----------------------------------------------------
    // List session key
    //-----------------------------------------------------
    /** Logged user */
    const KEY_LOGGED_USER                   = 'LOGGED_USER';
    /** String menu */
    const KEY_STRING_MENU                   = 'STRING_MENU';
    /** Allow use menu session */
    const KEY_ALLOW_SESSION_MENU            = 'ALLOW_SESSION_MENU';
    /** List actions of menu controller */
    const KEY_MENU_CONTROLLER_ACTION        = 'MENU_CONTROLLER_ACTION';
    /** City id */
    const KEY_SESSION_CITY_ID               = 'CITY_ID';
    /** District id */
    const KEY_SESSION_DISTRICT_ID           = 'DISTRICT_ID';
    /** Front end: String menu */
    const KEY_FE_STRING_MENU                = 'FE_STRING_MENU';
    /** Front end: Allow use menu session */
    const KEY_FE_ALLOW_SESSION_MENU         = 'FE_ALLOW_SESSION_MENU';
    /** Front end: List actions of menu controller */
    const KEY_FE_MENU_CONTROLLER_ACTION     = 'FE_MENU_CONTROLLER_ACTION';
    
    //-----------------------------------------------------
    // List actions
    //-----------------------------------------------------
    /** Actions: index */
    const KEY_ACTION_INDEX                  = 'index';
    /** Actions: admin */
    const KEY_ACTION_ADMIN                  = 'admin';
    /** Actions: view */
    const KEY_ACTION_VIEW                   = 'view';
    /** Actions: create */
    const KEY_ACTION_CREATE                 = 'create';
    /** Actions: update */
    const KEY_ACTION_UPDATE                 = 'update';
    /** Actions: delete */
    const KEY_ACTION_DELETE                 = 'delete';
    /** Actions: search user */
    const KEY_ACTION_SEARCH_USER            = 'searchUser';
    /** Actions: search customer */
    const KEY_ACTION_SEARCH_CUSTOMER        = 'searchCustomer';
    /** Actions: group */
    const KEY_ACTION_GROUP                  = 'group';
    /** Actions: user */
    const KEY_ACTION_USER                   = 'user';
    /** Actions: change password */
    const KEY_ACTION_CHANGE_PASSWORD        = 'changePassword';
    /** Actions: reset password */
    const KEY_ACTION_RESET_PASSWORD         = 'resetPassword';
    /** Actions: search user */
    const KEY_ACTION_SEARCH_STREET          = 'searchStreet';
    /** Actions: search districts by city */
    const KEY_ACTION_SEARCH_DISTRICT        = 'searchDistrictsByCity';
    /** Actions: search wards by district */
    const KEY_ACTION_SEARCH_WARD            = 'searchWardsByDistrict';
    /** Actions: search medical record */
    const KEY_ACTION_SEARCH_MEDICAL_RECORD  = 'searchMedicalRecord';
    /** Actions: search medicine */
    const KEY_ACTION_SEARCH_MEDICINE        = 'searchMedicine';
    
    //-----------------------------------------------------
    // List Image name
    //-----------------------------------------------------
    /** Image base path */
    const IMG_BASE_PATH                     = '/img/';
    /** Icon: new */
    const IMG_NEW_ICON                      = 'icon_new_24.png';
    /** Icon: edit */
    const IMG_EDIT_ICON                     = 'icon_edit_24.png';
    /** Icon: completed */
    const IMG_COMPLETED_ICON                = 'icon_completed_24.png';
    /** Icon: add */
    const IMG_ADD_ICON                      = 'add.png';
    /** Icon: view */
    const IMG_VIEW_ICON                     = 'icon_view_24.png';
    /** Icon: appointment */
    const IMG_APPOINTMENT_ICON              = 'icon_calendar_r.gif';
    /** Icon: receipt */
    const IMG_RECEIPT_ICON                  = 'icon_receipt_24.png';
    /** Icon: print */
    const IMG_PRINT_ICON                    = 'icon_print_24.png';
    /** Icon: print all */
    const IMG_PRINT_ALL_ICON                = 'icon_print_all_24.png';
    /** Icon: print all */
    const IMG_PRESCRIPTION_ICON             = 'icon_prescription_24.png';
    
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Group id: Medical record */
    const GROUP_MEDICAL_RECORD              = '1';
    /** Group id: Treatment */
    const GROUP_TREATMENT                   = '2';
    /** Item id: Update data */
    const ITEM_UPDATE_DATE                  = '0';
    /** Item id: Name */
    const ITEM_NAME                         = '1';
    /** Item id: Birthday */
    const ITEM_BIRTHDAY                     = '2';
    /** Item id: Medical history */
    const ITEM_MEDICAL_HISTORY              = '3';
    /** Item id: Gender */
    const ITEM_GENDER                       = '4';
    /** Item id: Age */
    const ITEM_AGE                          = '5';
    /** Item id: Phone */
    const ITEM_PHONE                        = '6';
    /** Item id: Address */
    const ITEM_ADDRESS                      = '7';
    /** Item id: Email */
    const ITEM_EMAIL                        = '8';
    /** Item id: Agent */
    const ITEM_AGENT                        = '9';
    /** Item id: Career */
    const ITEM_CAREER                       = '10';
    /** Item id: Characteristics */
    const ITEM_CHARACTERISTICS              = '11';
    /** Item id: Record number */
    const ITEM_RECORD_NUMBER                = '12';
    /** Item id: Start date */
    const ITEM_START_DATE                   = '13';
    /** Item id: End date */
    const ITEM_END_DATE                     = '14';
    /** Item id: Diagnosis */
    const ITEM_DIAGNOSIS                    = '15';
    /** Item id: Pathological */
    const ITEM_PATHOLOGICAL                 = '16';
    /** Item id: Doctor */
    const ITEM_DOCTOR                       = '17';
    /** Item id: Healthy */
    const ITEM_HEALTHY                      = '18';
    /** Item id: Status */
    const ITEM_STATUS                       = '19';
    /** Item id: Details */
    const ITEM_DETAILS                      = '20';
    /** Item id: Teeth */
    const ITEM_TEETH                        = '21';
    /** Item id: Treatment */
    const ITEM_TREATMENT                    = '22';
    /** Item id: NOTE */
    const ITEM_NOTE                         = '23';
    /** Item id: Type */
    const ITEM_TYPE                         = '24';
    /** Item id: Can update */
    const ITEM_CAN_UPDATE                   = '25';
    /** Item id: Id */
    const ITEM_ID                           = '26';
    /** Item id: Diagnosis Id */
    const ITEM_DIAGNOSIS_ID                 = '27';
    /** Item id: Pathological Id */
    const ITEM_PATHOLOGICAL_ID              = '28';
    /** Item id: Teeth Id */
    const ITEM_TEETH_ID                     = '29';
    /** Item id: Treatment type Id */
    const ITEM_TREATMENT_TYPE_ID            = '30';
    /** Item id: Description */
    const ITEM_DESCRIPTION                  = '31';
    /** Item id: Time id */
    const ITEM_TIME_ID                      = '32';
    /** Item id: Time */
    const ITEM_TIME                         = '33';
    /** Item id: Receipt */
    const ITEM_RECEIPT                      = '34';
    /** Item id: Discount */
    const ITEM_DISCOUNT                     = '35';
    /** Item id: Need approve */
    const ITEM_NEED_APPROVE                 = '36';
    /** Item id: Customer confirmed */
    const ITEM_CUSTOMER_CONFIRMED           = '37';
    /** Item id: Final */
    const ITEM_FINAL                        = '38';
    /** Item id: Insurance */
    const ITEM_INSURRANCE                   = '39';
    /** Item id: Teeth information */
    const ITEM_TEETH_INFO                   = '40';
    /** Item id: Customer debt information */
    const ITEM_CUSTOMER_DEBT                = '41';
    /** Item id: Image */
    const ITEM_IMAGE                        = '42';
    /** Item id: Image */
    const ITEM_IMAGE_TREATMENT              = '43';
    /** Item id: Agent id */
    const ITEM_AGENT_ID                     = '44';
    /** Item id: Price */
    const ITEM_PRICE                        = '45';
    /** Item id: Quantity */
    const ITEM_QUANTITY                     = '46';
    /** Item id: Total */
    const ITEM_TOTAL                        = '47';
    /** Item id: Debt */
    const ITEM_DEBT                         = '48';
    /** Item id: Receptionist */
    const ITEM_RECEIPTIONIST                = '49';
    /** Item id: Status string */
    const ITEM_STATUS_STR                   = '50';
    
    
    /**----- Message content -----*/
    const CONTENT00001  = 'Thu';
    const CONTENT00002  = 'Chi';
    const CONTENT00003  = 'Mã';
    const CONTENT00004  = 'Tiêu đề';
    const CONTENT00005  = 'Người Thu/Chi';
    const CONTENT00006  = 'Loại Thu/Chi';
    const CONTENT00007  = 'Số tiền';
    const CONTENT00008  = 'Tài khoản';
    const CONTENT00009  = 'Ngày Thu/Chi';
    const CONTENT00010  = 'Ngày tạo';
    const CONTENT00011  = 'Chi tiết';
    const CONTENT00012  = 'Tên tài khoản';
    const CONTENT00013  = 'Chủ tài khoản';
    const CONTENT00014  = 'Số dư';
    const CONTENT00015  = 'Danh sách tài khoản';
    const CONTENT00016  = 'Xem ';
    const CONTENT00017  = 'Tạo Mới';
    const CONTENT00018  = 'Thêm mới thành công.';
    const CONTENT00019  = 'Cập Nhật ';
    const CONTENT00020  = 'Cập nhật thành .';
    const CONTENT00021  = 'Danh Sách ';
    const CONTENT00022  = 'Danh sách Thu/Chi';
    const CONTENT00023  = 'Thu/Chi';
    const CONTENT00024  = 'Mã chức vụ';
    const CONTENT00025  = 'Mô tả chức vụ';
    const CONTENT00026  = 'Trạng thái';
    const CONTENT00027  = 'Active';
    const CONTENT00028  = 'Inactive';
    const CONTENT00029  = 'Nam';
    const CONTENT00030  = 'Nữ';
    const CONTENT00031  = 'Khác';
    const CONTENT00032  = 'Allow';
    const CONTENT00033  = 'Deny';
    const CONTENT00034  = '#';
    const CONTENT00035  = 'Cập nhật thành công';
    const CONTENT00036  = 'Phân quyền';
    const CONTENT00037  = 'Bạn không có quyền truy cập hoặc trang yêu cầu không tồn tại';
    const CONTENT00038  = 'Bạn có muốn xóa item này không?';
    const CONTENT00039  = 'Tên người dùng';
    const CONTENT00040  = 'Thư điện tử';
    const CONTENT00041  = 'Mật khẩu';
    const CONTENT00042  = 'Tên';
    const CONTENT00043  = 'Họ';
    const CONTENT00044  = 'Mã kế toán';
    const CONTENT00045  = 'Địa chỉ';
    const CONTENT00046  = 'Vai trò';
    const CONTENT00047  = 'Giới tính';
    const CONTENT00048  = 'Điện thoại';
    const CONTENT00049  = 'Tên khách hàng';
    const CONTENT00050  = 'Khu vực';
    const CONTENT00051  = 'Loại Khách hàng';
    const CONTENT00052  = 'Công ty mẹ';
    const CONTENT00053  = 'Đặc điểm Khách hàng';
    const CONTENT00054  = 'Người tạo';
    const CONTENT00055  = 'Tên sản phẩm';
    const CONTENT00056  = 'Mã sản phẩm';
    const CONTENT00057  = 'Đơn vị';
    const CONTENT00058  = 'Loại sản phẩm';
    const CONTENT00059  = 'Loại sản phẩm mẹ';
    const CONTENT00060  = 'Giá gốc';
    const CONTENT00061  = 'Hình ảnh';
    const CONTENT00062  = 'Mô tả';
    const CONTENT00063  = 'Tên Phân loại';
    const CONTENT00064  = 'Mã Phân loại';
    const CONTENT00065  = 'Thuộc Phân loại';
    const CONTENT00066  = 'Xin vui lòng nhập đúng dịnh dạng email xxx@yyy.zzz';
    const CONTENT00067  = 'Nhập từ khóa để tìm kiếm.';
    const CONTENT00068  = 'Đăng nhập';
    const CONTENT00069  = 'Thoát';
    const CONTENT00070  = 'Thông tin tài khoản';
    const CONTENT00071  = 'Đổi mật khẩu';
    const CONTENT00072  = 'Duy trì đăng nhập';
    const CONTENT00073  = 'Tìm kiếm nâng cao';
    const CONTENT00074  = 'Ngày nhập xuất';
    const CONTENT00075  = 'Kho';
    const CONTENT00076  = 'Phân loại';
    const CONTENT00077  = 'Mã đơn hàng';
    const CONTENT00078  = 'Thông tin hàng hóa trong kho';
    const CONTENT00079  = 'Dòng có dấu';
    const CONTENT00080  = 'là bắt buộc.';
    const CONTENT00081  = '<p class="note">Dòng có dấu <span class="required">*</span> là bắt buộc.</p>';
    const CONTENT00082  = 'Mã Thẻ kho';
    const CONTENT00083  = 'Số lượng';
    const CONTENT00084  = 'Ngày ghi sổ';
    const CONTENT00085  = 'Ngày giao hàng';
    const CONTENT00086  = 'Số chứng từ';
    const CONTENT00087  = 'Ngày chứng từ';
    const CONTENT00088  = 'Khách hàng';
    const CONTENT00089  = 'Loại đơn hàng';
    const CONTENT00090  = 'Diễn giải';
    const CONTENT00091  = 'Ghi chú';
    const CONTENT00092  = 'Tên viết tắt';
    const CONTENT00093  = 'Thuộc Tỉnh/Thành phố';
    const CONTENT00094  = 'Danh sách Quận/Huyện';
    const CONTENT00095  = 'Slug';
    const CONTENT00096  = 'Thuộc Quận/Huyện';
    const CONTENT00097  = 'Danh sách Phường/Xã';
    const CONTENT00098  = 'Danh sách Đường';
    const CONTENT00099  = 'Nghề nghiệp';
    const CONTENT00100  = 'Tên bệnh nhân';
    const CONTENT00101  = 'Ngày sinh';
    const CONTENT00102  = 'Tỉnh/Thành phố';
    const CONTENT00103  = 'Quận/Huyện';
    const CONTENT00104  = 'Phường/Xã';
    const CONTENT00105  = 'Tên Đường';
    const CONTENT00106  = 'Số nhà';
    const CONTENT00107  = 'Loại Bệnh nhân';
    const CONTENT00108  = 'Đặc điểm Bệnh nhân';
    const CONTENT00109  = 'Nguồn thông tin';
    const CONTENT00110  = 'Loại Thuốc';
    const CONTENT00111  = 'Cách dùng';
    const CONTENT00112  = 'Tên Thuốc';
    const CONTENT00113  = 'Hàm lượng';
    const CONTENT00114  = 'Đơn vị tính';
    const CONTENT00115  = 'Hoạt chất';
    const CONTENT00116  = 'Hãng sản xuất';
    const CONTENT00117  = 'Giá mua';
    const CONTENT00118  = 'Giá bán';
    const CONTENT00119  = 'Nhóm chẩn đoán';
    const CONTENT00120  = 'Nhóm chẩn đoán EN';
    const CONTENT00121  = 'Nội dung chẩn đoán';
    const CONTENT00122  = 'Nội dung chẩn đoán EN';
    const CONTENT00123  = 'Thuộc nhóm';
    const CONTENT00124  = 'Mã nhóm';
    const CONTENT00125  = 'Mã chẩn đoán';
    const CONTENT00126  = 'Bệnh lý';
    const CONTENT00127  = 'Chuyên khoa';
    const CONTENT00128  = 'Loại điều trị';
    const CONTENT00129  = 'Giá';
    const CONTENT00130  = 'Phí vật liệu';
    const CONTENT00131  = 'Phí Labo';
    const CONTENT00132  = 'Code';
    const CONTENT00133  = 'Loại tiền';
    const CONTENT00134  = 'VND';
    const CONTENT00135  = 'Bệnh nhân';
    const CONTENT00136  = 'Số bệnh án';
    const CONTENT00137  = 'Tiền sử bệnh';
    const CONTENT00138  = 'Hồ sơ bệnh án';
    const CONTENT00139  = 'Ngày bắt đầu';
    const CONTENT00140  = 'Ngày kết thúc';
    const CONTENT00141  = 'Bệnh lý cần điều trị';
    const CONTENT00142  = 'Tình trạng sức khỏe';
    const CONTENT00143  = 'Bác sĩ';
    const CONTENT00144  = 'Mã Đợt điều trị';
    const CONTENT00145  = 'Răng số';
//    const CONTENT00146  = 'Chi tiết đợt điều trị';
    const CONTENT00146  = 'Lần điều trị';
    const CONTENT00147  = 'Ngày thực hiện';
    const CONTENT00148  = 'Công việc';
    const CONTENT00149  = 'Mã tiến trình điều trị';
    const CONTENT00150  = 'Ngày kê đơn';
    const CONTENT00151  = 'Bác sĩ kê đơn';
    const CONTENT00152  = 'Lời dặn bác sĩ';
    const CONTENT00153  = 'Mã toa thuốc';
    const CONTENT00154  = 'Tên thuốc';
    const CONTENT00155  = 'Số lượng sáng';
    const CONTENT00156  = 'Số lượng trưa';
    const CONTENT00157  = 'Số lượng chiều';
    const CONTENT00158  = 'Số lượng tối';
    const CONTENT00159  = 'Lưu ý';
    const CONTENT00160  = 'Cài đặt chung';
    const CONTENT00161  = 'Cài đặt Email';
    const CONTENT00162  = 'Phiên làm việc của bạn đã hết hạn. Vui lòng đăng nhập lại';
    const CONTENT00163  = 'Ứng dụng di động';
    const CONTENT00164  = 'Phiên bản app đã cũ, vui lòng cập nhật phiên bản mới hơn để sử dụng';
    const CONTENT00165  = 'ĐĂNG NHẬP';
    const CONTENT00166  = 'Đăng nhập vào hệ thống';
    const CONTENT00167  = 'Trang quản trị';
    const CONTENT00168  = 'ĐĂNG XUẤT';
    const CONTENT00169  = 'Đăng xuất khỏi hệ thống';
    const CONTENT00170  = 'Số điện thoại';
    const CONTENT00171  = 'Danh sách bệnh nhân';
    const CONTENT00172  = 'Thông tin bệnh nhân';
    const CONTENT00173  = 'Hồ sơ bệnh nhân:';
//    const CONTENT00174  = 'Chi tiết điều trị';
    const CONTENT00174  = 'Lần điều trị';
    const CONTENT00175  = 'Email';
    const CONTENT00176  = 'Tạo mới bệnh nhân';
    const CONTENT00177  = 'Lịch hẹn';
    const CONTENT00178  = 'Cập nhật lịch hẹn';
    const CONTENT00179  = 'Đặt lịch hẹn - Tạo đợt khám mới';
    const CONTENT00180  = 'Tạo mới bệnh nhân thành công';
    const CONTENT00181  = 'Cập nhật lịch hẹn thành công';
    const CONTENT00182  = 'Thông tin lịch hẹn';
    const CONTENT00183  = 'Tài khoản không tồn tại';
    const CONTENT00184  = 'Sai mật khẩu';
    const CONTENT00185  = 'Đăng nhập không thành công, vui lòng thử lại';
    const CONTENT00186  = 'Đăng nhập thành công';
    const CONTENT00187  = 'Đăng xuất thành công';
    const CONTENT00188  = 'Trang chủ';
    const CONTENT00189  = 'Tên đệm và Tên';
    const CONTENT00190  = 'iOS';
    const CONTENT00191  = 'Android';
    const CONTENT00192  = 'Windows';
    const CONTENT00193  = 'Web';
    const CONTENT00194  = 'Truy xuất thông tin thành công';
    const CONTENT00195  = 'Tên đăng nhập';
    const CONTENT00196  = 'Nhập lại mật khẩu';
    const CONTENT00197  = 'Tên Chi nhánh';
    const CONTENT00198  = 'Ngày thành lập';
    const CONTENT00199  = 'Chi nhánh';
    const CONTENT00200  = 'Mã bệnh nhân không hợp lệ';
    const CONTENT00201  = 'Lịch sử điều trị';
    const CONTENT00202  = 'Thông tin tiền sử bệnh';
    const CONTENT00203  = 'Cập nhật không thành công';
    const CONTENT00204  = 'Hoàn thành';
    const CONTENT00205  = 'Đặt lịch hẹn thành công';
    const CONTENT00206  = 'Hình thức';
    const CONTENT00207  = 'Chi tiết công việc';
    const CONTENT00208  = 'Ngày giờ hẹn';
    const CONTENT00209  = 'Mật khẩu hiện tại không chính xác';
    const CONTENT00210  = 'Mật khẩu mới không được trùng tên tài khoản';
    const CONTENT00211  = 'Mật khẩu mới quá đơn giản, vui lòng chọn mật khẩu khác';
    const CONTENT00212  = 'Cần đổi mật khẩu mặc định';
    const CONTENT00213  = 'Đổi mật khẩu thành công';
    const CONTENT00214  = 'Có lỗi xảy ra';
    const CONTENT00215  = 'Mã Đợt điều trị không hợp lệ';
    const CONTENT00216  = 'Bệnh nhân chưa được tạo Hồ sơ bệnh án';
    const CONTENT00217  = 'Hồ sơ bệnh án của Bệnh nhân không hợp lệ';
    const CONTENT00218  = 'Mã Bác sĩ không hợp lệ';
    const CONTENT00219  = 'Mã chẩn đoán không hợp lệ';
    const CONTENT00220  = 'Mã bệnh lý cần điều trị không hợp lệ';
    const CONTENT00221  = 'Mã tình trạng sức khỏe không hợp lệ';
    const CONTENT00222  = 'Trạng thái không hợp lệ';
    const CONTENT00223  = 'Số răng không hợp lệ';
    const CONTENT00224  = 'Mã loại điều trị không hợp lệ';
//    const CONTENT00225  = 'Tạo chi tiết điều trị thành công';
    const CONTENT00225  = 'Tạo Lần điều trị thành công';
//    const CONTENT00226  = 'Mã Chi tiết điều trị không hợp lệ';
    const CONTENT00226  = 'Mã Lần điều trị không hợp lệ';
    const CONTENT00227  = 'Tạo tiến trình điều trị thành công';
    const CONTENT00228  = 'Mã tiến trình điều trị không hợp lệ';
    const CONTENT00229  = 'Cập nhật thông tin';
    const CONTENT00230  = 'Thêm Đợt điều trị';
    const CONTENT00231  = 'Chẩn đoán';
    const CONTENT00232  = 'Flag update';
    const CONTENT00233  = 'Tiến trình điều trị';
    const CONTENT00234  = 'Xin vui lòng nhập Ngày thực hiện';
    const CONTENT00235  = 'Xin vui lòng nhập Ngày điều trị';
    const CONTENT00237  = 'Triệu chứng';
    const CONTENT00238  = 'Mốc thời gian';
    const CONTENT00239  = 'Actions';
    const CONTENT00240  = 'Giờ hẹn';
    const CONTENT00241  = 'Ngày lập';
    const CONTENT00242  = 'Giảm';
    const CONTENT00243  = 'Cần xác nhận từ cấp trên';
    const CONTENT00244  = 'Khách hàng xác nhận';
    const CONTENT00245  = 'Tạo phiếu thu thành công';
    const CONTENT00246  = 'Người thu tiền';
    const CONTENT00247  = 'Bác sĩ xuất phiếu thu';
    const CONTENT00248  = 'Lễ tân xuất phiếu thu';
    const CONTENT00249  = 'File không phải là ảnh, không hợp lệ, chỉ cho phép JPG, JPEG, PNG. FILE IMAGE not image Invalid request ';
    const CONTENT00250  = 'Tên file không được quá 100 ký tự, vui lòng đặt tên ngắn hơn';
    const CONTENT00251  = 'Thanh toán';
    const CONTENT00252  = 'Hình ảnh';
    const CONTENT00253  = 'Danh sách phiếu thu';
    const CONTENT00254  = 'Tổng cộng';
    const CONTENT00255  = 'Dịch vụ';
    const CONTENT00256  = 'Thông tin thanh toán';
    const CONTENT00257  = 'Giảm';
    const CONTENT00258  = 'Thành tiền';
    const CONTENT00259  = 'Thực thu';
    const CONTENT00260  = 'Bảo hiểm có thể chi trả';
    const CONTENT00261  = 'Cài đặt SMS';
    const CONTENT00262  = 'Xoá tất cả';
    const CONTENT00263  = 'Exception occurred';
    const CONTENT00264  = 'In phiếu thu';
    const CONTENT00265  = 'Xác nhận thu';
    const CONTENT00266  = 'đã thu';
    const CONTENT00267  = 'Chưa thu';
    const CONTENT00268  = 'Mã này đã được sử dụng';
    const CONTENT00269  = 'Mã này chưa được tạo xin vui lòng tạo thêm mã trước';
    const CONTENT00270  = 'Xem thêm';
    const CONTENT00271  = 'QR code';
    const CONTENT00272  = 'Cập nhật thông tin';
    const CONTENT00273  = 'Tên website';
    const CONTENT00274  = 'Facebook';
    const CONTENT00275  = 'Zalo';
    const CONTENT00276  = 'Thông tin liên lạc';
    const CONTENT00277  = 'Mã số hồ sơ';
    const CONTENT00278  = 'Thông tin liên quan';
    const CONTENT00279  = 'Nhân viên kinh doanh';
    const CONTENT00280  = 'Danh sách điều trị';
    const CONTENT00281  = 'Lịch điều trị';
    const CONTENT00282  = 'Bắt đầu';
    const CONTENT00283  = 'Kết thúc';
    const CONTENT00284  = 'Răng ';
    const CONTENT00285  = 'Hàm trên';
    const CONTENT00286  = 'Hàm dưới';
    const CONTENT00287  = 'Cả 2 hàm';
    const CONTENT00288  = 'Tên loại phục hình';
    const CONTENT00289  = 'Thời gian bảo hành (tháng)';
    const CONTENT00290  = 'Loại phục hình';
    const CONTENT00291  = 'Bệnh lý đã có sẵn không thể tạo mới';
    const CONTENT00292  = 'Tạo Bệnh lý thành công';
    const CONTENT00293  = 'Thêm dòng ( Phím tắt F8 )';
    const CONTENT00294  = 'Cho phép ';
    const CONTENT00295  = 'Tên file không quá 100 ký tự';
    const CONTENT00296  = 'Xoá';
    const CONTENT00297  = 'Thứ tự';
    const CONTENT00298  = 'Hình ảnh X Quang';
    const CONTENT00299  = 'Mã này chưa được in thẻ';
    const CONTENT00300  = 'Còn nợ';
    const CONTENT00301  = 'PHIẾU THU (RECEIPTS)';
    const CONTENT00302  = 'Ngày/Date:';
    const CONTENT00303  = 'Hình thức/Type:';
    const CONTENT00304  = 'Tiền mặt/Cash';
    const CONTENT00305  = 'Bệnh nhân/Patient:';
    const CONTENT00306  = 'Mã/Patient code:';
    const CONTENT00307  = 'Điện thoại/Tel:';
    const CONTENT00308  = 'Địa chỉ/Address:';
    const CONTENT00309  = 'Dịch vụ';
    const CONTENT00310  = 'Services';
    const CONTENT00311  = 'Số toa/No'; // No use
    const CONTENT00312  = 'Website';
    const CONTENT00313  = 'SL';
    const CONTENT00314  = 'Qty';
    const CONTENT00315  = 'Đơn giá';
    const CONTENT00316  = 'Unit Price';
    const CONTENT00317  = 'Giảm giá';
    const CONTENT00318  = 'Discount';
    const CONTENT00319  = 'Thành tiền';
    const CONTENT00320  = 'After discount';
    const CONTENT00321  = 'Actual cost';
    const CONTENT00322  = 'Tổng cộng/Total:';
    const CONTENT00323  = 'Còn nợ/Debt:';
    const CONTENT00324  = 'Dư/Pay back';
    const CONTENT00325  = 'Nợ cũ/Old Debt:';
    const CONTENT00326  = 'Bệnh nhân/Patient';
    const CONTENT00327  = 'Người lập/Creator';
    const CONTENT00328  = 'Kế toán/Accountant';
    const CONTENT00329  = 'Thủ quỹ/Cashier';
    const CONTENT00330  = 'Thủ trưởng/Authorised';
    const CONTENT00331  = '(Ký tên/Signature)';
    const CONTENT00332  = 'Chẩn đoán đã có sẵn không thể tạo mới';
    const CONTENT00333  = 'Chưa có nhóm Chẩn đoán "Khác"';
    const CONTENT00334  = 'Tạo Chẩn đoán thành công';
    const CONTENT00335  = 'Tổng đã thu';
    const CONTENT00336  = 'Tổng chưa thu';
    const CONTENT00337  = 'Danh sách nhân sự';
    const CONTENT00338  = 'Chức vụ';
    const CONTENT00339  = 'Doanh thu';
    const CONTENT00340  = 'Doanh thu hôm nay';
    const CONTENT00341  = 'Công nợ hôm nay';
    const CONTENT00342  = 'Doanh thu tháng này';
    const CONTENT00343  = 'Ngày';
    const CONTENT00344  = 'Khám';
    const CONTENT00345  = 'Miễn phí';
    const CONTENT00346  = 'Cập nhật';
    const CONTENT00347  = 'Khoản chi';
    const CONTENT00348  = 'Tạo phiếu thu';
    const CONTENT00349  = 'Tìm';
    const CONTENT00350  = 'Tháng này';
    const CONTENT00351  = 'Tháng trước';
    const CONTENT00352  = 'Tổng số hồ sơ';
    const CONTENT00353  = 'Tổng tiền';
    const CONTENT00354  = 'Giảm giá';
    const CONTENT00355  = 'Tổng thực thu';
    const CONTENT00356  = 'Còn nợ';
    const CONTENT00357  = 'Hôm qua';
    const CONTENT00358  = 'Hôm nay';
    const CONTENT00359  = 'Hôm trước';
    const CONTENT00360  = 'Phiếu thu cũ';
    const CONTENT00361  = 'Đã đặt lịch trước';
    const CONTENT00362  = 'Vừa tạo';
    const CONTENT00363  = 'Tra cứu thông tin Bệnh Nhân';
    const CONTENT00367  = 'Tạo mới Lần điều trị';
    const CONTENT00368  = 'Năm sinh';
    const CONTENT00369  = 'Năm sinh (Nếu không xin được thông tin Ngày sinh)';
    const CONTENT00370  = 'Chưa thu';
    const CONTENT00371  = 'Xong';
    const CONTENT00372  = 'Lưu và tạo phiếu thu';
    const CONTENT00373  = 'In thêm';
    const CONTENT00374  = 'Chọn phiếu thu cần in';
    const CONTENT00375  = 'Chức năng hiện đang hoàn thiện, xin vui lòng thử lại sau';
    const CONTENT00376  = 'Không có phiếu thu';
    const CONTENT00377  = 'Lưu';
    const CONTENT00378  = 'Chọn ngày';
    const CONTENT00379  = 'Tạo toa thuốc';
    const CONTENT00380  = 'Hình ảnh trước và sau điều trị';
    const CONTENT00381  = 'Thời gian bảo hành';
    const CONTENT00382  = 'Thời gian còn lại';
    const CONTENT00383  = 'Điều trị đã hoàn thành, không thể cập nhật.';
    const CONTENT00384  = 'Tìm kiếm bệnh nhân';
    const CONTENT00385  = 'Chọn chi nhánh';
    const CONTENT00386  = 'Cập nhật thông tin Lần điều trị';
    const CONTENT00387  = 'Thanh toán thành công';
    const CONTENT00388  = 'Mã Lần điều trị';
    const CONTENT00389  = 'Mã bệnh nhân';
    const CONTENT00390  = 'S-T-C-T';
    const CONTENT00391  = 'Hình ảnh Điều Trị';
    const CONTENT00392  = 'Bảo hành';
    const CONTENT00393  = 'Lịch hẹn tái khám';
    const CONTENT00394  = 'Bệnh nhân cũ';
    const CONTENT00395  = 'Tuổi';
    const CONTENT00396  = 'Thời gian điều trị';
    const CONTENT00397  = 'Xuất excel';
    const CONTENT00398  = 'Bệnh nhân mới';
    const CONTENT00399  = 'Chi tiết doanh thu của Bác sĩ';
    const CONTENT00400  = 'Báo cáo chi tiết chi hằng ngày';
    const CONTENT00401  = 'Bảng tổng hợp Thu - Chi';
    const CONTENT00402  = 'Mới';
    const CONTENT00403  = 'Hủy';
    const CONTENT00404  = 'Loại khuyến mãi';
    const CONTENT00405  = 'KM chiết khấu';
    const CONTENT00406  = 'KM khấu trừ';
    const CONTENT00407  = 'Hoạt động';
    const CONTENT00408  = 'Không hoạt động';
    const CONTENT00409  = 'Tất cả';
    const CONTENT00410  = '%';
    const CONTENT00411  = 'Áp dụng khuyến mãi';
    const CONTENT00412  = 'Không áp dụng';
    const CONTENT00413  = 'Loại điều trị cũ';
    const CONTENT00414  = 'Người quản lý';
    const CONTENT00415  = 'Phòng Lab';
    const CONTENT00416  = 'Ngày gửi yêu cầu';
    const CONTENT00417  = 'Ngày nhận';
    const CONTENT00418  = 'Ngày giờ thử răng';
    const CONTENT00419  = 'Màu răng';
    const CONTENT00420  = 'Số răng';
    const CONTENT00421  = 'Số CMND';
    const CONTENT00422  = 'Ngày cấp';
    const CONTENT00423  = 'Nơi cấp';
    const CONTENT00424  = 'Ngày vào làm';
    const CONTENT00425  = 'Tạo yêu cầu phục hình';
    const CONTENT00426  = 'Tên chuyên mục';
    const CONTENT00427  = 'Chuyên mục cha';
    const CONTENT00428  = 'Nội dung';
    const CONTENT00429  = 'Total';
    const CONTENT00430  = 'Đã thu';
    const CONTENT00431  = 'Bạn có chắc chắn muốn xóa?';
    const CONTENT00432  = 'TOA THUỐC';
    const CONTENT00433  = 'Giới tính/Sex';
    const CONTENT00434  = 'Năm sinh/YOB';
    const CONTENT00435  = 'Giờ nhận';
    const CONTENT00436  = 'Ngày giờ nhận';
    const CONTENT00437  = 'Yêu cầu';
    const CONTENT00438  = 'Mã Chi nhánh';
    const CONTENT00439  = 'Mã loại điều trị';
    const CONTENT00440  = 'Phiếu thu';
    const CONTENT00441  = 'Báo cáo doanh thu';
    const CONTENT00442  = 'Ngày hẹn';
    const CONTENT00443  = 'Mã Tỉnh/Thành phố';
    const CONTENT00444  = 'Mã Quận Huyện';
    const CONTENT00445  = 'Mã Phường Xã';
    const CONTENT00446  = 'Record liên quan';
    const CONTENT00447  = 'Tạo thông tin bảo hành';
    const CONTENT00448  = 'Không thể tìm thấy Bệnh nhân';
    const CONTENT00449  = 'Không thể tìm thấy Lần điều trị';
    const CONTENT00450  = 'Nhận hàng';
    const CONTENT00451  = 'Cưa đai';
    const CONTENT00452  = 'Điêu khắc sáp';
    const CONTENT00453  = 'Nung kim loại';
    const CONTENT00454  = 'Sườn kim loại';
    const CONTENT00455  = 'Quét OPEC';
    const CONTENT00456  = 'Đắp sứ + Nướng';
    const CONTENT00457  = 'Mài sứ (thử sứ thô)';
    const CONTENT00458  = 'Nướng bóng';
    const CONTENT00459  = 'Lễ tân kiểm tra và đóng gói';
    const CONTENT00460  = 'Phòng Zico (Máy cắt CAM)';
    const CONTENT00461  = 'Nung Zico';
    const CONTENT00462  = 'Mài Sườn (thử sườn)';
    const CONTENT00463  = 'Tháo lắp';
    const CONTENT00464  = 'Làm gối sáp (Cắn khớp)';
    const CONTENT00465  = 'Lên răng (Thử răng)';
    const CONTENT00466  = 'Ép nhựa';
    const CONTENT00467  = 'Mới tạo';
    const CONTENT00468  = 'Người chịu trách nhiệm';
    const CONTENT00469  = 'Lý do';
    const CONTENT00470  = 'Tháng';
    const CONTENT00471  = 'Thông tin liên quan';
    const CONTENT00472  = 'Văn bản';
    const CONTENT00473  = 'Hoàn tất';
    const CONTENT00474  = 'Người duyệt';
    const CONTENT00475  = 'Ngày duyệt';
    const CONTENT00476  = 'Đã duyệt';
    const CONTENT00477  = 'Không duyệt';
    const CONTENT00478  = 'Yêu cầu cập nhật';
    const CONTENT00479  = 'Năm';
    const CONTENT00480  = 'Loại ngày nghỉ lễ';
    const CONTENT00481  = 'Hệ số công';
    const CONTENT00482  = 'Tên ngày nghỉ';
    const CONTENT00483  = 'Ngày';
    const CONTENT00484  = 'Ngày nghỉ bù';
    const CONTENT00485  = 'Tên ca';
    const CONTENT00486  = 'Từ';
    const CONTENT00487  = 'Đến';
    const CONTENT00488  = 'Nhóm user';
    const CONTENT00489  = 'Ca thường';
    const CONTENT00490  = 'Nhân viên';
    const CONTENT00491  = 'Ca làm việc';
    const CONTENT00492  = 'Kế hoạch làm việc';
    const CONTENT00493  = 'Tên tham số';
    const CONTENT00494  = 'Method';
    const CONTENT00495  = 'Giá trị';
    const CONTENT00496  = 'Hệ số';
    const CONTENT00497  = 'Tên hệ số';
    const CONTENT00498  = 'Không thể xoá do còn [Giá trị của Hệ số] liên quan';
    const CONTENT00499  = 'Đã xoá';
    const CONTENT00500  = 'Không thể xoá do còn [Công thức] liên quan';
    const CONTENT00501  = 'Công thức';
    const CONTENT00502  = 'Loại bảng lương';
    const CONTENT00503  = 'Tính theo ngày';
    const CONTENT00504  = 'Báo cáo hằng ngày';
    const CONTENT00505  = 'Đang yêu cầu duyệt';
    const CONTENT00506  = 'Đã xác nhận';
    const CONTENT00507  = 'Cần xem xét lại';
    const CONTENT00508  = 'Chưa tạo';
    const CONTENT00509  = 'Chưa duyệt';
    const CONTENT00510  = 'Báo cáo không tồn tại';
    const CONTENT00511  = 'Trạng thái cập nhật không hợp lệ';
    const CONTENT00512  = 'Công thức tính theo từng ngày';
    const CONTENT00513  = 'Công thức tính theo khoảng thời gian';
    const CONTENT00514  = 'Đang tính';
    const CONTENT00515  = 'Đang gửi yêu cầu';
    const CONTENT00516  = 'Đã chốt';
    const CONTENT00517  = 'Không thể xoá do còn [Bảng lương] liên quan';
    const CONTENT00518  = 'Ngày hoạt động';
    const CONTENT00519  = 'Mã số thuế';
    const CONTENT00520  = 'Giám đốc';
    const CONTENT00521  = 'Không thể xoá do còn [' . self::CONTENT00525 . '] liên quan';
    const CONTENT00522  = 'Khối phòng ban';
    const CONTENT00525  = 'Phòng ban';
    const CONTENT00526  = 'Công ty';
    const CONTENT00527  = 'Trưởng phòng';
    const CONTENT00528  = 'Phó phòng';
    const CONTENT00529  = 'Thuộc Phòng ban';
    const CONTENT00530  = 'Phòng';
    const CONTENT00531  = 'Loại hợp đồng';
    const CONTENT00532  = 'Lương cơ bản';
    const CONTENT00533  = 'Lương đóng BHXH';
    const CONTENT00534  = 'Lương trách nhiệm';
    const CONTENT00535  = 'Phụ cấp cố định';
    const CONTENT00536  = 'Lịch làm việc';
    const CONTENT00537  = 'Giờ hành chính';
    const CONTENT00538  = 'Theo ca';
    const CONTENT00539  = 'Chờ duyệt';
    const CONTENT00540  = 'Nhân viên xin nghỉ';
    const CONTENT00541  = 'Ngày nghỉ lễ';
    const CONTENT00542  = 'Không thể xoá do còn [' . self::CONTENT00541 . '] liên quan';
    const CONTENT00543  = 'Màu hiển thị';
    const CONTENT00544  = 'Các Giá trị cũ';
    const CONTENT00545  = 'Tham số';
    const CONTENT00546  = 'Xem chi tiết';
    const CONTENT00547  = 'Tác vụ';
    const CONTENT00548  = 'Sao chép';
    const CONTENT00549  = 'Thêm dòng';
    const CONTENT00550  = 'Sản phẩm';
    const CONTENT00551  = 'Không thể xoá do còn [' . self::CONTENT00550 . '] liên quan';
    const CONTENT00552  = 'Kho hàng';
    const CONTENT00553  = 'Thẻ kho';
    const CONTENT00554  = 'Không thể xoá do còn [' . self::CONTENT00553 . '] liên quan';
    const CONTENT00555  = 'Đang xử lý';
    const CONTENT00556  = 'Đã tiếp nhận';
    const CONTENT00557  = 'Lễ tân tiếp nhận';
}
