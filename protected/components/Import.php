<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Import
 *
 * @author nguyenpt
 */
class Import {
    public static function importCities() {
        $allCities = array(
            "1" => "Hà Nội",
            "2" => "TP HCM",
            "3" => "Hải Phòng",
            "4" => "Đà Nẵng",
            "5" => "Hà Giang",
            "6" => "Cao Bằng",
            "7" => "Lai Châu",
            "8" => "Lào Cai",
            "9" => "Tuyên Quang",
            "10" => "Lạng Sơn",
            "11" => "Bắc Kạn",
            "12" => "Thái Nguyên",
            "13" => "Yên Bái",
            "14" => "Sơn La",
            "15" => "Phú Thọ",
            "16" => "Vĩnh Phúc",
            "17" => "Quảng Ninh",
            "18" => "Bắc Giang",
            "19" => "Bắc Ninh",
            "20" => "Hà Tây",
            "21" => "Hải Dương",
            "22" => "Hưng Yên",
            "23" => "Hoà Bình",
            "24" => "Hà Nam",
            "25" => "Nam Định",
            "26" => "Thái Bình",
            "27" => "Ninh Bình",
            "28" => "Thanh Hóa",
            "29" => "Nghệ An",
            "30" => "Hà Tĩnh",
            "31" => "Quảng Bình",
            "32" => "Quảng Trị",
            "33" => "Thừa Thiên-Huế",
            "34" => "Quảng Nam",
            "35" => "Quảng Ngãi",
            "36" => "Kon Tum",
            "37" => "Bình Định",
            "38" => "Gia Lai",
            "39" => "Phú Yên",
            "40" => "Đăk Lăk",
            "41" => "Khánh Hòa",
            "42" => "Lâm Đồng",
            "43" => "Bình Phước",
            "44" => "Bình Dương",
            "45" => "Ninh Thuận",
            "46" => "Tây Ninh",
            "47" => "Bình Thuận",
            "48" => "Đồng Nai",
            "49" => "Long An",
            "50" => "Đồng Tháp",
            "51" => "An Giang",
            "52" => "Bà Rịa-Vũng Tàu",
            "53" => "Tiền Giang",
            "54" => "Kiên Giang",
            "55" => "Cần Thơ",
            "56" => "Bến Tre",
            "57" => "Vĩnh Long",
            "58" => "Trà Vinh",
            "59" => "Sóc Trăng",
            "60" => "Bạc Liêu",
            "61" => "Cà Mau",
            "62" => "Điện Biên",
            "63" => "Đăk Nông",
            "64" => "Hậu Giang"
        );
        foreach ($allCities as $id => $city) {
            $model = new Cities();
            $model->id = $id;
            $model->name = $city;
            $model->short_name = CommonProcess::getShortString($city);
            $model->status = DomainConst::DEFAULT_STATUS_ACTIVE;
            $model->slug = CommonProcess::getSlugString($city);
            $model->save();
        }
    }
    
    public static function importDistricts() {
        $data = array(
//            "TP HCM" => array(
//                "Quận 1+1" => array(
//                    "Phường Tân Định",
//                    "Phường Đa Kao",
//                    "Phường Bến Nghé",
//                    "Phường Bến Thành",
//                    "Phường Nguyễn Thái Bình",
//                    "Phường Phạm Ngũ Lão",
//                    "Phường Cầu Ông Lãnh",
//                    "Phường Cô Giang",
//                    "Phường Nguyễn Cư Trinh",
//                    "Phường Cầu Kho"
//                ),
//                "Quận 2+2" => array(
//                    "Phường Thảo Điền",
//                    "Phường An Phú",
//                    "Phường Bình An",
//                    "Phường Bình Trưng Đông",
//                    "Phường Bình Trưng Tây",
//                    "Phường Bình Khánh",
//                    "Phường An Khánh",
//                    "Phường Cát Lái",
//                    "Phường Thạnh Mỹ Lợi",
//                    "Phường An Lợi Đông",
//                    "Phường Thủ Thiêm"
//                ),
//                "Quận 3+3" => array(
//                    "Phường 08",
//                    "Phường 07",
//                    "Phường 14",
//                    "Phường 12",
//                    "Phường 11",
//                    "Phường 13",
//                    "Phường 06",
//                    "Phường 09",
//                    "Phường 10",
//                    "Phường 04",
//                    "Phường 05",
//                    "Phường 03",
//                    "Phường 02",
//                    "Phường 01"
//                ),
//                "Quận 4+4" => array(
//                    "Phường 12",
//                    "Phường 13",
//                    "Phường 09",
//                    "Phường 06",
//                    "Phường 08",
//                    "Phường 10",
//                    "Phường 05",
//                    "Phường 18",
//                    "Phường 14",
//                    "Phường 04",
//                    "Phường 03",
//                    "Phường 16",
//                    "Phường 02",
//                    "Phường 15",
//                    "Phường 01"
//                ),
//                "Quận 5+5" => array(
//                    "Phường 04",
//                    "Phường 09",
//                    "Phường 03",
//                    "Phường 12",
//                    "Phường 02",
//                    "Phường 08",
//                    "Phường 15",
//                    "Phường 07",
//                    "Phường 01",
//                    "Phường 11",
//                    "Phường 14",
//                    "Phường 05",
//                    "Phường 06",
//                    "Phường 10",
//                    "Phường 13"
//                ),
//                "Quận 6+6" => array(
//                    "Phường 14",
//                    "Phường 13",
//                    "Phường 09",
//                    "Phường 06",
//                    "Phường 12",
//                    "Phường 05",
//                    "Phường 11",
//                    "Phường 02",
//                    "Phường 01",
//                    "Phường 04",
//                    "Phường 08",
//                    "Phường 03",
//                    "Phường 07"
//                ),
//                "Quận 7+7" => array(
//                    "Phường Tân Thuận Đông",
//                    "Phường Tân Thuận Tây",
//                    "Phường Tân Kiểng",
//                    "Phường Tân Hưng",
//                    "Phường Bình Thuận",
//                    "Phường Tân Quy",
//                    "Phường Phú Thuận",
//                    "Phường Tân Phú",
//                    "Phường Tân Phong",
//                    "Phường Phú Mỹ"
//                ),
//                "Quận 8+8" => array(
//                    "Phường 08",
//                    "Phường 02",
//                    "Phường 01",
//                    "Phường 03",
//                    "Phường 11",
//                    "Phường 09",
//                    "Phường 10",
//                    "Phường 04",
//                    "Phường 13",
//                    "Phường 12",
//                    "Phường 05",
//                    "Phường 14",
//                    "Phường 06",
//                    "Phường 15",
//                    "Phường 16",
//                    "Phường 07"
//                ),
//                "Quận 9+9" => array(
//                    "Phường Long Bình",
//                    "Phường Long Thạnh Mỹ",
//                    "Phường Tân Phú",
//                    "Phường Hiệp Phú",
//                    "Phường Tăng Nhơn Phú A",
//                    "Phường Tăng Nhơn Phú B",
//                    "Phường Phước Long B",
//                    "Phường Phước Long A",
//                    "Phường Trường Thạnh",
//                    "Phường Long Phước",
//                    "Phường Long Trường",
//                    "Phường Phước Bình",
//                    "Phường Phú Hữu"
//                ),
//                "Quận 10+10" => array(
//                    "Phường 15",
//                    "Phường 13",
//                    "Phường 14",
//                    "Phường 12",
//                    "Phường 11",
//                    "Phường 10",
//                    "Phường 09",
//                    "Phường 01",
//                    "Phường 08",
//                    "Phường 02",
//                    "Phường 04",
//                    "Phường 07",
//                    "Phường 05",
//                    "Phường 06",
//                    "Phường 03"
//                ),
//                "Quận 11+11" => array(
//                    "Phường 15",
//                    "Phường 05",
//                    "Phường 14",
//                    "Phường 11",
//                    "Phường 03",
//                    "Phường 10",
//                    "Phường 13",
//                    "Phường 08",
//                    "Phường 09",
//                    "Phường 12",
//                    "Phường 07",
//                    "Phường 06",
//                    "Phường 04",
//                    "Phường 01",
//                    "Phường 02",
//                    "Phường 16"
//                ),
//                "Quận 12+12" => array(
//                    "Phường Thạnh Xuân",
//                    "Phường Thạnh Lộc",
//                    "Phường Hiệp Thành",
//                    "Phường Thới An",
//                    "Phường Tân Chánh Hiệp",
//                    "Phường An Phú Đông",
//                    "Phường Tân Thới Hiệp",
//                    "Phường Trung Mỹ Tây",
//                    "Phường Tân Hưng Thuận",
//                    "Phường Đông Hưng Thuận",
//                    "Phường Tân Thới Nhất"
//                ),
//                "Quận Gò Vấp+13" => array(
//		    "Phường 15",
//		    "Phường 13",
//		    "Phường 17",
//		    "Phường 06",
//		    "Phường 16",
//		    "Phường 12",
//		    "Phường 14",
//		    "Phường 10",
//		    "Phường 05",
//		    "Phường 07",
//		    "Phường 04",
//		    "Phường 01",
//		    "Phường 09",
//		    "Phường 08",
//		    "Phường 11",
//		    "Phường 03"
//                ),
//                "Quận Tân Bình+14" => array(
//		    "Phường 02",
//		    "Phường 04",
//		    "Phường 12",
//		    "Phường 13",
//		    "Phường 01",
//		    "Phường 03",
//		    "Phường 11",
//		    "Phường 07",
//		    "Phường 05",
//		    "Phường 10",
//		    "Phường 06",
//		    "Phường 08",
//		    "Phường 09",
//		    "Phường 14",
//		    "Phường 15"
//                ),
//                "Quận Tân Phú+15" => array(
//		    "Phường Tân Sơn Nhì",
//		    "Phường Tây Thạnh",
//		    "Phường Sơn Kỳ",
//		    "Phường Tân Qúy",
//		    "Phường Tân Thành",
//		    "Phường Phú Thọ Hoà",
//		    "Phường Phú Thạnh",
//		    "Phường Phú Trung",
//		    "Phường Hoà Thạnh",
//		    "Phường Hiệp Tân",
//		    "Phường Tân Thới Hoà"
//                ),
//                "Quận Bình Thạnh+16" => array(
//		    "Phường 13",
//		    "Phường 11",
//		    "Phường 27",
//		    "Phường 26",
//		    "Phường 12",
//		    "Phường 25",
//		    "Phường 05",
//		    "Phường 07",
//		    "Phường 24",
//		    "Phường 06",
//		    "Phường 14",
//		    "Phường 15",
//		    "Phường 02",
//		    "Phường 01",
//		    "Phường 03",
//		    "Phường 17",
//		    "Phường 21",
//		    "Phường 22",
//		    "Phường 19",
//		    "Phường 28"
//                ),
//                "Quận Phú Nhuận+17" => array(
//		    "Phường 04",
//		    "Phường 05",
//		    "Phường 09",
//		    "Phường 07",
//		    "Phường 03",
//		    "Phường 01",
//		    "Phường 02",
//		    "Phường 08",
//		    "Phường 15",
//		    "Phường 10",
//		    "Phường 11",
//		    "Phường 17",
//		    "Phường 14",
//		    "Phường 12",
//		    "Phường 13"
//                ),
//                "Quận Thủ Đức+18" => array(
//		    "Phường Linh Xuân",
//		    "Phường Bình Chiểu",
//		    "Phường Linh Trung",
//		    "Phường Tam Bình",
//		    "Phường Tam Phú",
//		    "Phường Hiệp Bình Phước",
//		    "Phường Hiệp Bình Chánh",
//		    "Phường Linh Chiểu",
//		    "Phường Linh Tây",
//		    "Phường Linh Đông",
//		    "Phường Bình Thọ",
//		    "Phường Trường Thọ"
//                ),
//                "Quận Bình Tân+19" => array(
//		    "Phường Bình Hưng Hòa",
//		    "Phường Bình Hưng Hoà A",
//		    "Phường Bình Hưng Hoà B",
//		    "Phường Bình Trị Đông",
//		    "Phường Bình Trị Đông A",
//		    "Phường Bình Trị Đông B",
//		    "Phường Tân Tạo",
//		    "Phường Tân Tạo A",
//		    "Phường An Lạc",
//		    "Phường An Lạc A"
//                ),
//                "Huyện Bình Chánh+54" => array(
//		    "Thị trấn Tân Túc",
//		    "Xã Phạm Văn Hai",
//		    "Xã Vĩnh Lộc A",
//		    "Xã Vĩnh Lộc B",
//		    "Xã Bình Lợi",
//		    "Xã Lê Minh Xuân",
//		    "Xã Tân Nhựt",
//		    "Xã Tân Kiên",
//		    "Xã Bình Hưng",
//		    "Xã Phong Phú",
//		    "Xã An Phú Tây",
//		    "Xã Hưng Long",
//		    "Xã Đa Phước",
//		    "Xã Tân Quý Tây",
//		    "Xã Bình Chánh",
//		    "Xã Quy Đức"
//                ),
//                "Huyện Củ Chi+52" => array(
//		    "Thị trấn Củ Chi",
//		    "Xã Phú Mỹ Hưng",
//		    "Xã An Phú",
//		    "Xã Trung Lập Thượng",
//		    "Xã An Nhơn Tây",
//		    "Xã Nhuận Đức",
//		    "Xã Phạm Văn Cội",
//		    "Xã Phú Hòa Đông",
//		    "Xã Trung Lập Hạ",
//		    "Xã Trung An",
//		    "Xã Phước Thạnh",
//		    "Xã Phước Hiệp",
//		    "Xã Tân An Hội",
//		    "Xã Phước Vĩnh An",
//		    "Xã Thái Mỹ",
//		    "Xã Tân Thạnh Tây",
//		    "Xã Hòa Phú",
//		    "Xã Tân Thạnh Đông",
//		    "Xã Bình Mỹ",
//		    "Xã Tân Phú Trung",
//		    "Xã Tân Thông Hội"
//                ),
//                "Huyện Hóc Môn+53" => array(
//		    "Thị trấn Hóc Môn",
//		    "Xã Tân Hiệp",
//		    "Xã Nhị Bình",
//		    "Xã Đông Thạnh",
//		    "Xã Tân Thới Nhì",
//		    "Xã Thới Tam Thôn",
//		    "Xã Xuân Thới Sơn",
//		    "Xã Tân Xuân",
//		    "Xã Xuân Thới Đông",
//		    "Xã Trung Chánh",
//		    "Xã Xuân Thới Thượng",
//		    "Xã Bà Điểm"
//                ),
//                "Huyện Nhà Bè+55" => array(
//		    "Thị trấn Nhà Bè",
//		    "Xã Phước Kiển",
//		    "Xã Phước Lộc",
//		    "Xã Nhơn Đức",
//		    "Xã Phú Xuân",
//		    "Xã Long Thới",
//		    "Xã Hiệp Phước"
//                ),
//                "Huyện Cần Giờ+56" => array(
//		    "Thị trấn Cần Thạnh",
//		    "Xã Bình Khánh",
//		    "Xã Tam Thôn Hiệp",
//		    "Xã An Thới Đông",
//		    "Xã Thạnh An",
//		    "Xã Long Hòa",
//		    "Xã Lý Nhơn"
//                )
//            ),
            "An Giang" => array(
                "Thành phố Long Xuyên" => array(
	
                ),
                "Thị xã Châu Đốc" => array(

                ),
                "Huyện An Phú" => array(

                ),
                "Huyện Tân Châu" => array(

                ),
                "Huyện Phú Tân" => array(

                ),
                "Huyện Tịnh Biên" => array(

                ),
                "Huyện Tri Tôn" => array(

                ),
                "Huyện Châu Phú" => array(

                ),
                "Huyện Chợ Mới" => array(

                ),
                "Huyện Châu Thành" => array(

                ),
                "Huyện Thoại Sơn" => array(

                )
            ),
            "Bà Rịa - Vũng Tàu" => array(
                "Thành phố Vũng Tàu" => array(

                ),
                "Thành phố Bà Rịa" => array(

                ),
                "Huyện Xuyên Mộc" => array(

                ),
                "Huyện Long Điền" => array(

                ),
                "Huyện Côn Đảo" => array(

                ),
                "Huyện Tân Thành" => array(

                ),
                "Huyện Châu Đức" => array(

                ),
                "Huyện Đất Đỏ" => array(

                )
            ),
            "Bắc Giang" => array(
                "Thành phố Bắc Giang" => array(

                ),
                "Huyện Yên Thế" => array(

                ),
                "Huyện Lục Ngạn" => array(

                ),
                "Huyện Sơn Động" => array(

                ),
                "Huyện Lục Nam" => array(

                ),
                "Huyện Tân Yên" => array(

                ),
                "Huyện Hiệp Hoà" => array(

                ),
                "Lạng Giang" => array(

                ),
                "Huyện Việt Yên" => array(

                ),
                "Huyện Yên Dũng" => array(

                )
            ),
            "Bắc Kạn" => array(
                "Thị xã Bắc Kạn" => array(

                ),
                "Huyện Chợ Đồn" => array(

                ),
                "Huyện Bạch Thông" => array(

                ),
                "Huyện Na Rì" => array(

                ),
                "Huyện Ngân Sơn" => array(

                ),
                "Huyện Ba Bể" => array(

                ),
                "Huyện Chợ Mới" => array(

                ),
                "Huyện Pác Nặm" => array(

                )
            ),
            "Bạc Liêu" => array(
                "Thành phố Bạc Liêu" => array(

                ),
                "Huyện Vĩnh Lợi" => array(

                ),
                "Huyện Hồng Dân" => array(

                ),
                "Huyện Giá Rai" => array(

                ),
                "Huyện Phước Long" => array(

                ),
                "Huyện Đông Hải" => array(

                ),
                "Huyện Hoà Bình" => array(

                )
            ),
            "Bắc Ninh" => array(
                "Thành phố Bắc Ninh" => array(

                ),
                "Huyện Yên Phong" => array(

                ),
                "Huyện Quế Võ" => array(

                ),
                "Huyện Tiên Du" => array(

                ),
                "Thị xã Từ Sơn" => array(

                ),
                "Huyện Thuận Thành" => array(

                ),
                "Huyện Gia Bình" => array(

                ),
                "Huyện Lương Tài" => array(

                )
            ),
            "Bến Tre" => array(
                "Thành phố Bến Tre" => array(
	
                ),
                "Huyện Châu Thành" => array(

                ),
                "Huyện Chợ Lách" => array(

                ),
                "Huyện Mỏ Cày Bắc" => array(

                ),
                "Huyện Giồng Trôm" => array(

                ),
                "Huyện Bình Đại" => array(

                ),
                "Huyện Ba Tri" => array(

                ),
                "Huyện Thạnh Phú" => array(

                ),
                "Huyện Mỏ Cày Nam" => array(

                )
            ),
            "Bình Định" => array(
                "Thành phố Quy Nhơn" => array(

                ),
                "Huyện An Lão" => array(

                ),
                "Huyện Hoài Ân" => array(

                ),
                "Huyện Hoài Nhơn" => array(

                ),
                "Huyện Phù Mỹ" => array(

                ),
                "Huyện Phù Cát" => array(

                ),
                "Huyện Vĩnh Thạnh" => array(

                ),
                "Huyện Tây Sơn" => array(

                ),
                "Huyện Vân Canh" => array(

                ),
                "Thị xã An Nhơn" => array(

                ),
                "Huyện Tuy Phước" => array(

                )
            ),
            "Bình Dương" => array(
                "Thành phố Thủ Dầu Một" => array(

                ),
                "Huyện Bến Cát" => array(

                ),
                "Huyện Tân Uyên" => array(

                ),
                "Thị xã Thuận An" => array(

                ),
                "Thị xã Dĩ An" => array(

                ),
                "Huyện Phú Giáo" => array(

                ),
                "Huyện Dầu Tiếng" => array(

                )
            ),
            "Bình Phước" => array(
                "Thị xã Đồng Xoài" => array(

                ),
                "Huyện Đồng Phú" => array(

                ),
                "Huyện Chơn Thành" => array(

                ),
                "Huyện Bình Long" => array(

                ),
                "Huyện Lộc Ninh" => array(

                ),
                "Huyện Bù Đốp" => array(

                ),
                "Huyện Phước Long" => array(

                ),
                "Huyện Bù Đăng" => array(

                ),
                "Huyện Hớn Quản" => array(

                ),
                "Huyện Bù Gia Mập" => array(

                )
            ),
            "Bình Thuận" => array(
                "Thành phố Phan Thiết" => array(
	
                ),
                "Huyện Tuy Phong" => array(

                ),
                "Huyện Bắc Bình" => array(

                ),
                "Huyện Hàm Thuận Bắc" => array(

                ),
                "Huyện Hàm Thuận Nam" => array(

                ),
                "Huyện Hàm Tân" => array(

                ),
                "Huyện Đức Linh" => array(

                ),
                "Huyện Tánh Linh" => array(

                ),
                "Huyện đảo Phú Quý" => array(

                ),
                "Thị xã La Gi" => array(

                )
            ),
            "Cà Mau" => array(
                "Thành phố Cà Mau" => array(

                ),
                "Huyện Thới Bình" => array(

                ),
                "Huyện U Minh" => array(

                ),
                "Huyện Trần Văn Thời" => array(

                ),
                "Huyện Cái Nước" => array(

                ),
                "Huyện Đầm Dơi" => array(

                ),
                "Huyện Ngọc Hiển" => array(

                ),
                "Huyện Năm Căn" => array(

                ),
                "Huyện Phú Tân" => array(

                )
            ),
            "Cao Bằng" => array(
                "Thành phố Cao Bằng" => array(

                ),
                "Huyện Bảo Lạc" => array(

                ),
                "Huyện Thông Nông" => array(

                ),
                "Huyện Hà Quảng" => array(

                ),
                "Huyện Trà Lĩnh" => array(

                ),
                "Huyện Trùng Khánh" => array(

                ),
                "Huyện Nguyên Bình" => array(

                ),
                "Huyện Hoà An" => array(

                ),
                "Huyện Quảng Uyên" => array(

                ),
                "Huyện Thạch An" => array(

                ),
                "Huyện Hạ Lang" => array(

                ),
                "Huyện Bảo Lâm" => array(

                ),
                "Huyện Phục Hoà" => array(

                )
            ),
            "Đắk Lắk" => array(
                "Thành phố Buôn Ma Thuột" => array(

                ),
                "Huyện Ea H Leo" => array(

                ),
                "Huyện Krông Buk" => array(

                ),
                "Huyện Krông Năng" => array(

                ),
                "Huyện Ea Súp" => array(

                ),
                "Huyện Cư Mgar" => array(

                ),
                "Huyện Krông Pắc" => array(

                ),
                "Huyện Ea Kar" => array(

                ),
                "Huyện M'Đrăk" => array(

                ),
                "Huyện Krông Ana" => array(

                ),
                "Huyện Krông Bông" => array(

                ),
                "Huyện Lăk" => array(

                ),
                "Huyện Buôn Đôn" => array(

                ),
                "Huyện Cư Kuin" => array(

                ),
                "Thị Xã Buôn Hồ" => array(

                )
            ),
            "Đắk Nông" => array(
                "Thị xã Gia Nghĩa" => array(

                ),
                "Huyện Đăk RLấp" => array(

                ),
                "Huyện Đăk Mil" => array(

                ),
                "Huyện Cư Jút" => array(

                ),
                "Huyện Đăk Song" => array(

                ),
                "Huyện Krông Nô" => array(

                ),
                "Huyện Đăk GLong" => array(

                ),
                "Huyện Tuy Đức" => array(

                )
            ),
            "Điện Biên" => array(
                "TP. Điện Biên Phủ" => array(

                ),
                "Thị xã Mường Lay" => array(

                ),
                "Huyện Điện Biên" => array(

                ),
                "Huyện Tuần Giáo" => array(

                ),
                "Huyện Mường Chà" => array(

                ),
                "Huyện Tủa Chùa" => array(

                ),
                "Huyện Điện Biên Đông" => array(

                ),
                "Huyện Mường Nhé" => array(

                ),
                "Huyện Mường Ảng" => array(

                )
            ),
            "Đồng Nai" => array(
                "Thành phố Biên Hoà" => array(

                ),
                "Huyện Vĩnh Cửu" => array(

                ),
                "Huyện Tân Phú" => array(

                ),
                "Huyện Định Quán" => array(

                ),
                "Huyện Thống Nhất" => array(

                ),
                "Thị xã Long Khánh" => array(

                ),
                "Huyện Xuân Lộc" => array(

                ),
                "Huyện Long Thành" => array(

                ),
                "Huyện Nhơn Trạch" => array(

                ),
                "Huyện Trảng Bom" => array(

                ),
                "Huyện Cẩm Mỹ" => array(

                )
            ),
            "Đồng Tháp" => array(
                "Thành phố Cao Lãnh" => array(

                ),
                "Thành phố Sa Đéc" => array(

                ),
                "Huyện Tân Hồng" => array(

                ),
                "Huyện Hồng Ngự" => array(

                ),
                "Huyện Tam Nông" => array(

                ),
                "Huyện Thanh Bình" => array(

                ),
                "Huyện Cao Lãnh" => array(

                ),
                "Huyện Lấp Vò" => array(

                ),
                "Huyện Tháp Mười" => array(

                ),
                "Huyện Lai Vung" => array(

                ),
                "Huyện Châu Thành" => array(

                ),
                "Thị Xã Hồng Ngự" => array(

                )
            ),
            "Gia Lai" => array(
                "Thành phố Pleiku" => array(

                ),
                "Huyện Chư Păh" => array(

                ),
                "Huyện Mang Yang" => array(

                ),
                "Huyện Kbang" => array(

                ),
                "Thị xã An Khê" => array(

                ),
                "Huyện Kông Chro" => array(

                ),
                "Huyện Đức Cơ" => array(

                ),
                "Huyện Chư Prông" => array(

                ),
                "Huyện Chư Sê" => array(

                ),
                "Thị xã Ayun Pa" => array(

                ),
                "Huyện Krông Pa" => array(

                ),
                "Huyện Ia Grai" => array(

                ),
                "Huyện Đak Đoa" => array(

                ),
                "Huyện Ia Pa" => array(

                ),
                "Huyện Đak Pơ" => array(

                ),
                "Huyện Phú Thiện" => array(

                ),
                "Huyện Chư Pưh" => array(

                )
            ),
            "Hà Giang" => array(
                "Thành phố Hà Giang" => array(

                ),
                "Huyện Đồng Văn" => array(

                ),
                "Huyện Mèo Vạc" => array(

                ),
                "Huyện Yên Minh" => array(

                ),
                "Huyện Quản Bạ" => array(

                ),
                "Huyện Vị Xuyên" => array(

                ),
                "Huyện Bắc Mê" => array(

                ),
                "Huyện Hoàng Su Phì" => array(

                ),
                "Huyện Xín Mần" => array(

                ),
                "Huyện Bắc Quang" => array(

                ),
                "Huyện Quang Bình" => array(

                )
            ),
            "Hà Nam" => array(
                "Thành phố Phủ Lý" => array(

                ),
                "Huyện Duy Tiên" => array(

                ),
                "Huyện Kim Bảng" => array(

                ),
                "Huyện Lý Nhân" => array(

                ),
                "Huyện Thanh Liêm" => array(

                ),
                "Huyện Bình Lục" => array(

                )
            ),
            "Hà Tĩnh" => array(
                "Thành phố Hà Tĩnh" => array(

                ),
                "Thị xã Hồng Lĩnh" => array(

                ),
                "Huyện Hương Sơn" => array(

                ),
                "Huyện Đức Thọ" => array(

                ),
                "Huyện Nghi Xuân" => array(

                ),
                "Huyện Can Lộc" => array(

                ),
                "Huyện Hương Khê" => array(

                ),
                "Huyện Thạch Hà" => array(

                ),
                "Huyện Cẩm Xuyên" => array(

                ),
                "Huyện Kỳ Anh" => array(

                ),
                "Huyện Vũ Quang" => array(

                ),
                "Huyện Lộc Hà" => array(

                )
            ),
            "Hải Dương" => array(
                "Thành phố Hải Dương" => array(

                ),
                "Thị xã Chí Linh" => array(

                ),
                "Huyện Nam Sách" => array(

                ),
                "Huyện Kinh Môn" => array(

                ),
                "Huyện Gia Lộc" => array(

                ),
                "Huyện Tứ Kỳ" => array(

                ),
                "Huyện Thanh Miện" => array(

                ),
                "Huyện Ninh Giang" => array(

                ),
                "Huyện Cẩm Giàng" => array(

                ),
                "Huyện Thanh Hà" => array(

                ),
                "Huyện Kim Thành" => array(

                ),
                "Huyện Bình Giang" => array(

                )
            ),
            "Hậu Giang" => array(
                "Thành phố Vị Thanh" => array(

                ),
                "Huyện Vị Thuỷ" => array(

                ),
                "Huyện Long Mỹ" => array(

                ),
                "Huyện Phụng Hiệp" => array(

                ),
                "Huyện Châu Thành" => array(

                ),
                "Huyện Châu Thành A" => array(

                ),
                "Thị xã Ngã Bảy" => array(

                )
            ),
            "Hòa Bình" => array(
                "Thành phố Hoà Bình" => array(

                ),
                "Huyện Đà Bắc" => array(

                ),
                "Huyện Mai Châu" => array(

                ),
                "Huyện Tân Lạc" => array(

                ),
                "Huyện Lạc Sơn" => array(

                ),
                "Huyện Kỳ Sơn" => array(

                ),
                "Huyện Lư­ơng Sơn" => array(

                ),
                "Huyện Kim Bôi" => array(

                ),
                "Huyện Lạc Thuỷ" => array(

                ),
                "Huyện Yên Thuỷ" => array(

                ),
                "Huyện Cao Phong" => array(

                )
            ),
            "Hưng Yên" => array(
                "Thành phố Hưng Yên" => array(

                ),
                "Huyện Kim Động" => array(

                ),
                "Huyện Ân Thi" => array(

                ),
                "Huyện Khoái Châu" => array(

                ),
                "Huyện Yên Mỹ" => array(

                ),
                "Huyện Tiên Lữ" => array(

                ),
                "Huyện Phù Cừ" => array(

                ),
                "Huyện Mỹ Hào" => array(

                ),
                "Huyện Văn Lâm" => array(

                ),
                "Huyện Văn Giang" => array(

                )
            ),
            "Khánh Hòa" => array(
                "Thành phố Nha Trang" => array(

                ),
                "Huyện Vạn Ninh" => array(

                ),
                "Huyện Ninh Hoà" => array(

                ),
                "Huyện Diên Khánh" => array(

                ),
                "Huyện Khánh Vĩnh" => array(

                ),
                "Thị xã Cam Ranh" => array(

                ),
                "Huyện Khánh Sơn" => array(

                ),
                "Huyện đảo Trường Sa" => array(

                ),
                "Huyện Cam Lâm" => array(

                )
            ),
            "Kiên Giang" => array(
                "Thành phố Rạch Giá" => array(

                ),
                "Thị xã Hà Tiên" => array(

                ),
                "Huyện Kiên Lương" => array(

                ),
                "Huyện Hòn Đất" => array(

                ),
                "Huyện Tân Hiệp" => array(

                ),
                "Huyện Châu Thành" => array(

                ),
                "Huyện Giồng Riềng" => array(

                ),
                "Huyện Gò Quao" => array(

                ),
                "Huyện An Biên" => array(

                ),
                "Huyện An Minh" => array(

                ),
                "Huyện Vĩnh Thuận" => array(

                ),
                "Huyện Phú Quốc" => array(

                ),
                "Huyện Kiên Hải" => array(

                ),
                "Huyện U Minh Thượng" => array(

                ),
                "Huyện Giang Thành" => array(

                )
            ),
            "Kon Tum" => array(
                "Thành phố Kon Tum" => array(

                ),
                "Huyện Đăk Glei" => array(

                ),
                "Huyện Ngọc Hồi" => array(

                ),
                "Huyện Đăk Tô" => array(

                ),
                "Huyện Sa Thầy" => array(

                ),
                "Huyện Kon Plông" => array(

                ),
                "Huyện Đăk Hà" => array(

                ),
                "Huyện Kon Rẫy" => array(

                ),
                "Huyện Tu Mơ Rông" => array(

                )
            ),
            "Lai Châu" => array(
                "Thành Phố Lai Châu" => array(

                ),
                "Huyện Tam Đường" => array(

                ),
                "Huyện Phong Thổ" => array(

                ),
                "Huyện Sìn Hồ" => array(

                ),
                "Huyện Mường Tè" => array(

                ),
                "Huyện Than Uyên" => array(

                ),
                "Huyện Tân Uyên" => array(

                ),
                "Huyện Nậm Nhùm" => array(

                )
            ),
            "Lâm Đồng" => array(
                "Thành phố Đà Lạt" => array(
	
                ),
                "Thành phố Bảo Lộc" => array(

                ),
                "Huyện Đức Trọng" => array(

                ),
                "Huyện Di Linh" => array(

                ),
                "Huyện Đơn Dương" => array(

                ),
                "Huyện Lạc Dương" => array(

                ),
                "Huyện Đạ Huoai" => array(

                ),
                "Huyện Đạ Tẻh" => array(

                ),
                "Huyện Cát Tiên" => array(

                ),
                "Huyện Lâm Hà" => array(

                ),
                "Huyện Bảo Lâm" => array(

                ),
                "Huyện Đam Rông" => array(

                )
            ),
            "Lạng Sơn" => array(
                "Thành phố Lạng Sơn" => array(

                ),
                "Huyện Tràng Định" => array(

                ),
                "Huyện Bình Gia" => array(

                ),
                "Huyện Văn Lãng" => array(

                ),
                "Huyện Bắc Sơn" => array(

                ),
                "Huyện Văn Quan" => array(

                ),
                "Huyện Cao Lộc" => array(

                ),
                "Huyện Lộc Bình" => array(

                ),
                "Huyện Chi Lăng" => array(

                ),
                "Huyện Đình Lập" => array(

                ),
                "Huyện Hữu Lũng" => array(

                )
            ),
            "Lào Cai" => array(
                "Thành phố Lào Cai" => array(

                ),
                "Huyện Xi Ma Cai" => array(

                ),
                "Huyện Bát Xát" => array(

                ),
                "Huyện Bảo Thắng" => array(

                ),
                "Huyện Sa Pa" => array(

                ),
                "Huyện Văn Bàn" => array(

                ),
                "Huyện Bảo Yên" => array(

                ),
                "Huyện Bắc Hà" => array(

                ),
                "Huyện Mường Khương" => array(

                )
            ),
            "Long An" => array(
                "Thành phố Tân An" => array(

                ),
                "Huyện Vĩnh Hưng" => array(

                ),
                "Huyện Mộc Hoá" => array(

                ),
                "Huyện Tân Thạnh" => array(

                ),
                "Huyện Thạnh Hoá" => array(

                ),
                "Huyện Đức Huệ" => array(

                ),
                "Huyện Đức Hoà" => array(

                ),
                "Huyện Bến Lức" => array(

                ),
                "Huyện Thủ Thừa" => array(

                ),
                "Huyện Châu Thành" => array(

                ),
                "Huyện Tân Trụ" => array(

                ),
                "Huyện Cần Đước" => array(

                ),
                "Huyện Cần Giuộc" => array(

                ),
                "Huyện Tân Hưng" => array(

                ),
                "Thị xã Kiến Tường" => array(

                )
            ),
            "Nam Định" => array(
                "Thành phố Nam Định" => array(

                ),
                "Huyện Mỹ Lộc" => array(

                ),
                "Huyện Xuân Trường" => array(

                ),
                "Huyện Giao Thủy" => array(

                ),
                "Huyện Ý Yên" => array(

                ),
                "Huyện Vụ Bản" => array(

                ),
                "Huyện Nam Trực" => array(

                ),
                "Huyện Trực Ninh" => array(

                ),
                "Huyện Nghĩa Hưng" => array(

                ),
                "Huyện Hải Hậu" => array(

                )
            ),
            "Nghệ An" => array(
                "Thành phố Vinh" => array(

                ),
                "Thị xã Cửa Lò" => array(

                ),
                "Huyện Quỳ Châu" => array(

                ),
                "Huyện Quỳ Hợp" => array(

                ),
                "Huyện Nghĩa Đàn" => array(

                ),
                "Huyện Quỳnh Lưu" => array(

                ),
                "Huyện Kỳ Sơn" => array(

                ),
                "Huyện Tương Dương" => array(

                ),
                "Huyện Con Cuông" => array(

                ),
                "Huyện Tân Kỳ" => array(

                ),
                "Huyện Yên Thành" => array(

                ),
                "Huyện Diễn Châu" => array(

                ),
                "Huyện Anh Sơn" => array(

                ),
                "Huyện Đô Lương" => array(

                ),
                "Huyện Thanh Chương" => array(

                ),
                "Huyện Nghi Lộc" => array(

                ),
                "Huyện Nam Đàn" => array(

                ),
                "Huyện Hưng Nguyên" => array(

                ),
                "Huyện Quế Phong" => array(

                ),
                "Thị Xã Thái Hòa" => array(

                ),
                "Thị Xã Hoàng Mai" => array(

                )
            ),
            "Ninh Bình" => array(
                "Thành phố Ninh Bình" => array(

                ),
                "Thị xã Tam Điệp" => array(

                ),
                "Huyện Nho Quan" => array(

                ),
                "Huyện Gia Viễn" => array(

                ),
                "Huyện Hoa Lư" => array(

                ),
                "Huyện Yên Mô" => array(

                ),
                "Huyện Kim Sơn" => array(

                ),
                "Huyện Yên Khánh" => array(

                )
            ),
            "Ninh Thuận" => array(
                "Thành phố Phan Rang -Tháp Chàm" => array(

                ),
                "Huyện Ninh Sơn" => array(

                ),
                "Huyện Ninh Hải" => array(

                ),
                "Huyện Ninh Phước" => array(

                ),
                "Huyện Bác Ái" => array(

                ),
                "Huyện Thuận Bắc" => array(

                ),
                "Huyện Thuận Nam" => array(

                )
            ),
            "Phú Thọ" => array(
                "Thành phố Việt Trì" => array(

                ),
                "Thị xã Phú Thọ" => array(

                ),
                "Huyện Đoan Hùng" => array(

                ),
                "Huyện Thanh Ba" => array(

                ),
                "Huyện Hạ Hoà" => array(

                ),
                "Huyện Cẩm Khê" => array(

                ),
                "Huyện Yên Lập" => array(

                ),
                "Huyện Thanh Sơn" => array(

                ),
                "Huyện Phù Ninh" => array(

                ),
                "Huyện Lâm Thao" => array(

                ),
                "Huyện Tam Nông" => array(

                ),
                "Huyện Thanh Thủy" => array(

                ),
                "Huyện Tân Sơn" => array(

                )
            ),
            "Quảng Bình" => array(
                "Thành phố Đồng Hới" => array(

                ),
                "Thị xã Ba Đồn" => array(

                ),
                "Huyện Tuyên Hoá" => array(

                ),
                "Huyện Minh Hoá" => array(

                ),
                "Huyện Quảng Trạch" => array(

                ),
                "Huyện Bố Trạch" => array(

                ),
                "Huyện Quảng Ninh" => array(

                ),
                "Huyện Lệ Thuỷ" => array(

                )
            ),
            "Quảng Nam" => array(
                "Thành phố Tam Kỳ" => array(

                ),
                "Thành phố Hội An" => array(

                ),
                "Huyện Duy Xuyên" => array(

                ),
                "Huyện Điện Bàn" => array(

                ),
                "Huyện Đại Lộc" => array(

                ),
                "Huyện Quế Sơn" => array(

                ),
                "Huyện Hiệp Đức" => array(

                ),
                "Huyện Thăng Bình" => array(

                ),
                "Huyện Núi Thành" => array(

                ),
                "Huyện Tiên Phước" => array(

                ),
                "Huyện Bắc Trà My" => array(

                ),
                "Huyện Đông Giang" => array(

                ),
                "Huyện Nam Giang" => array(

                ),
                "Huyện Phước Sơn" => array(

                ),
                "Huyện Nam Trà My" => array(

                ),
                "Huyện Tây Giang" => array(

                ),
                "Huyện Phú Ninh" => array(

                ),
                "Huyện Nông Sơn" => array(

                )
            ),
            "Quảng Ngãi" => array(
                "Thành phố Quảng Ngãi" => array(

                ),
                "Huyện Lý Sơn" => array(

                ),
                "Huyện Bình Sơn" => array(

                ),
                "Huyện Trà Bồng" => array(

                ),
                "Huyện Sơn Tịnh" => array(

                ),
                "Huyện Sơn Hà" => array(

                ),
                "Huyện Tư Nghĩa" => array(

                ),
                "Huyện Nghĩa Hành" => array(

                ),
                "Huyện Minh Long" => array(

                ),
                "Huyện Mộ Đức" => array(

                ),
                "Huyện Đức Phổ" => array(

                ),
                "Huyện Ba Tơ" => array(

                ),
                "Huyện Sơn Tây" => array(

                ),
                "Huyện Tây Trà" => array(

                )
            ),
            "Quảng Ninh" => array(
                "Thành phố Hạ Long" => array(

                ),
                "Thành phố Cẩm Phả" => array(

                ),
                "Thành phố Uông Bí" => array(

                ),
                "Thành phố Móng Cái" => array(

                ),
                "Huyện Bình Liêu" => array(

                ),
                "Huyện Đầm Hà" => array(

                ),
                "Huyện Hải Hà" => array(

                ),
                "Huyện Tiên Yên" => array(

                ),
                "Huyện Ba Chẽ" => array(

                ),
                "Huyện Đông Triều" => array(

                ),
                "Thị xã Quảng Yên" => array(

                ),
                "Huyện Hoành Bồ" => array(

                ),
                "Huyện Vân Đồn" => array(

                ),
                "Huyện Cô Tô" => array(

                )
            ),
            "Quảng Trị" => array(
                "Thành phố Đông Hà" => array(

                ),
                "Thị xã Quảng Trị" => array(

                ),
                "Huyện Vĩnh Linh" => array(

                ),
                "Huyện Gio Linh" => array(

                ),
                "Huyện Cam Lộ" => array(

                ),
                "Huyện Triệu Phong" => array(

                ),
                "Huyện Hải Lăng" => array(

                ),
                "Huyện Hướng Hóa" => array(

                ),
                "Huyện Đăk Rông" => array(

                ),
                "Huyện đảo Cồn Cỏ" => array(

                )
            ),
            "Sóc Trăng" => array(
                "Thành phố Sóc Trăng" => array(
	
                ),
                "Huyện Kế Sách" => array(

                ),
                "Huyện Mỹ Tú" => array(

                ),
                "Huyện Mỹ Xuyên" => array(

                ),
                "Huyện Thạnh Trị" => array(

                ),
                "Huyện Long Phú" => array(

                ),
                "Thị xã Vĩnh Châu" => array(

                ),
                "Huyện Cù Lao Dung" => array(

                ),
                "Huyện Ngã Năm" => array(

                ),
                "Huyện Châu Thành" => array(

                ),
                "Huyện Trần Đề" => array(

                )
            ),
            "Sơn La" => array(
                "Thành phố Sơn La" => array(

                ),
                "Huyện Quỳnh Nhai" => array(

                ),
                "Huyện Mường La" => array(

                ),
                "Huyện Thuận Châu" => array(

                ),
                "Huyện Bắc Yên" => array(

                ),
                "Huyện Phù Yên" => array(

                ),
                "Huyện Mai Sơn" => array(

                ),
                "Huyện Yên Châu" => array(

                ),
                "Huyện Sông Mã" => array(

                ),
                "Huyện Mộc Châu" => array(

                ),
                "huyện Sốp Cộp" => array(

                ),
                "Huyện Vân Hồ" => array(

                )
            ),
            "Tây Ninh" => array(
                "Thị xã Tây Ninh" => array(
	
                ),
                "Huyện Tân Biên" => array(

                ),
                "Huyện Tân Châu" => array(

                ),
                "Huyện Dương Minh Châu" => array(

                ),
                "Huyện Châu Thành" => array(

                ),
                "Huyện Hòa Thành" => array(

                ),
                "Huyện Bến Cầu" => array(

                ),
                "Huyện Gò Dầu" => array(

                ),
                "Huyện Trảng Bàng" => array(

                )
            ),
            "Thái Bình" => array(
                "Thành phố Thái Bình" => array(

                ),
                "Huyện Quỳnh Phụ" => array(

                ),
                "Huyện Hưng Hà" => array(

                ),
                "Huyện Đông Hưng" => array(

                ),
                "Huyện Vũ Thư" => array(

                ),
                "Huyện Kiến Xương" => array(

                ),
                "Huyện Tiền Hải" => array(

                ),
                "Huyện Thái Thuỵ" => array(

                )
            ),
            "Thái Nguyên" => array(
                "Thành phố Thái Nguyên" => array(

                ),
                "Thị xã Sông Công" => array(

                ),
                "Huyện Định Hoá" => array(

                ),
                "Huyện Phú Lương" => array(

                ),
                "Huyện Võ Nhai" => array(

                ),
                "Huyện Đại Từ" => array(

                ),
                "Huyện Đồng Hỷ" => array(

                ),
                "Huyện Phú Bình" => array(

                ),
                "Huyện Phổ Yên" => array(

                )
            ),
            "Thanh Hóa" => array(
                "Thành phố Thanh Hóa" => array(

                ),
                "Thị xã Bỉm Sơn" => array(

                ),
                "Thị xã Sầm Sơn" => array(

                ),
                "Huyện Quan Hoá" => array(

                ),
                "Huyện Quan Sơn" => array(

                ),
                "Huyện Mường Lát" => array(

                ),
                "Huyện Bá Thước" => array(

                ),
                "Huyện Thường Xuân" => array(

                ),
                "Huyện Như Xuân" => array(

                ),
                "Huyện Như Thanh" => array(

                ),
                "Huyện Lang Chánh" => array(

                ),
                "Huyện Ngọc Lặc" => array(

                ),
                "Huyện Thạch Thành" => array(

                ),
                "Huyện Cẩm Thủy" => array(

                ),
                "Huyện Thọ Xuân" => array(

                ),
                "Huyện Vĩnh Lộc" => array(

                ),
                "Huyện Thiệu Hoá" => array(

                ),
                "Huyện Triệu Sơn" => array(

                ),
                "Huyện Nông Cống" => array(

                ),
                "Huyện Đông Sơn" => array(

                ),
                "Huyện Hà Trung" => array(

                ),
                "Huyện Hoằng Hoá" => array(

                ),
                "Huyện Nga Sơn" => array(

                ),
                "Huyện Hậu Lộc" => array(

                ),
                "Huyện Quảng Xương" => array(

                ),
                "Huyện Tĩnh Gia" => array(

                ),
                "Huyện Yên Định" => array(

                )
            ),
            "Thừa Thiên Huế" => array(
                "Thành phố Huế" => array(

                ),
                "Huyện Phong Điền" => array(

                ),
                "Huyện Quảng Điền" => array(

                ),
                "Thị xã Hương Trà" => array(

                ),
                "Huyện Phú Vang" => array(

                ),
                "Thị xã Hương Thủy" => array(

                ),
                "Huyện Phú Lộc" => array(

                ),
                "Huyện Nam Đông" => array(

                ),
                "Huyện A Lưới" => array(

                )
            ),
            "Tiền Giang" => array(
                "Thành phố Mỹ Tho" => array(
	
                ),
                "Thị xã Gò Công" => array(

                ),
                "Huyện Cái bè" => array(

                ),
                "Huyện Cai lậy" => array(

                ),
                "Huyện Châu thành" => array(

                ),
                "Huyện Chợ Gạo" => array(

                ),
                "Huyện Gò Công Tây" => array(

                ),
                "Huyện Gò Công Đông" => array(

                ),
                "Huyện Tân Phước" => array(

                ),
                "Huyện Tân Phú Đông" => array(

                )
            ),
            "Trà Vinh" => array(
                "Thành phố Trà Vinh" => array(
	
                ),
                "Huyện Càng Long" => array(

                ),
                "Huyện Cầu Kè" => array(

                ),
                "Huyện Tiểu Cần" => array(

                ),
                "Huyện Châu Thành" => array(

                ),
                "Huyện Trà Cú" => array(

                ),
                "Huyện Cầu Ngang" => array(

                ),
                "Huyện Duyên Hải" => array(

                ),
                "Quận Ninh Kiều" => array(

                ),
                "Quận Bình Thuỷ" => array(

                ),
                "Quận Cái Răng" => array(

                ),
                "Quận Ô Môn" => array(

                ),
                "Huyện Phong Điền" => array(

                ),
                "Huyện Cờ Đỏ" => array(

                ),
                "Huyện Vĩnh Thạnh" => array(

                ),
                "Quận Thốt Nốt" => array(

                ),
                "Huyện Thới Lai" => array(

                )
            ),
            "Tuyên Quang" => array(
                "Thành phố Tuyên Quang" => array(

                ),
                "Huyện Lâm Bình" => array(

                ),
                "Huyện Na Hang" => array(

                ),
                "Huyện Chiêm Hoá" => array(

                ),
                "Huyện Hàm Yên" => array(

                ),
                "Huyện Yên Sơn" => array(

                ),
                "Huyện Sơn Dương" => array(

                )
            ),
            "Vĩnh Long" => array(
                "Thành phố Vĩnh Long" => array(

                ),
                "Huyện Long Hồ" => array(

                ),
                "Huyện Mang Thít" => array(

                ),
                "Thị xã Bình Minh" => array(

                ),
                "Huyện Tam Bình" => array(

                ),
                "Huyện Trà Ôn" => array(

                ),
                "Huyện Vũng Liêm" => array(

                ),
                "Huyện Bình Tân" => array(

                )
            ),
            "Vĩnh Phúc" => array(
                "Thành phố Vĩnh Yên" => array(

                ),
                "Huyện Tam Dương" => array(

                ),
                "Huyện Lập Thạch" => array(

                ),
                "Huyện Vĩnh Tường" => array(

                ),
                "Huyện Yên Lạc" => array(

                ),
                "Huyện Bình Xuyên" => array(

                ),
                "Huyện Sông Lô" => array(

                ),
                "Thị xã Phúc Yên" => array(

                ),
                "Huyện Tam Đảo" => array(

                )
            ),
            "Yên Bái" => array(
                "Thành phố Yên Bái" => array(

                ),
                "Thị xã Nghĩa Lộ" => array(

                ),
                "Huyện Văn Yên" => array(

                ),
                "Huyện Yên Bình" => array(

                ),
                "Huyện Mù Cang Chải" => array(

                ),
                "Huyện Văn Chấn" => array(

                ),
                "Huyện Trấn Yên" => array(

                ),
                "Huyện Trạm Tấu" => array(

                ),
                "Huyện Lục Yên" => array(

                )
            ),
            "Phú Yên" => array(
                "Thành phố Tuy Hòa" => array(

                ),
                "Huyện Đồng Xuân" => array(

                ),
                "Thị Xã Sông Cầu" => array(

                ),
                "Huyện Tuy An" => array(

                ),
                "Huyện Sơn Hòa" => array(

                ),
                "Huyện Sông Hinh" => array(

                ),
                "Huyện Đông Hòa" => array(

                ),
                "Huyện Phú Hòa" => array(

                ),
                "Huyện Tây Hòa" => array(

                )
            ),
            "Cần Thơ" => array(

            ),
            "Đà Nẵng" => array(
                "Quận Hải Châu" => array(

                ),
                "Quận Thanh Khê" => array(

                ),
                "Quận Sơn Trà" => array(

                ),
                "Quận Ngũ Hành Sơn" => array(

                ),
                "Quận Liên Chiểu" => array(

                ),
                "Huyện Hoà Vang" => array(

                ),
                "Quận Cẩm Lệ" => array(

                )
            ),
            "Hải Phòng" => array(
                "Quận Hồng Bàng" => array(

                ),
                "Quận Lê Chân" => array(

                ),
                "Quận Ngô Quyền" => array(

                ),
                "Quận Kiến An" => array(

                ),
                "Quận Hải An" => array(

                ),
                "Quận Đồ Sơn" => array(

                ),
                "Huyện An Lão" => array(

                ),
                "Huyện Kiến Thụy" => array(

                ),
                "Huyện Thủy Nguyên" => array(

                ),
                "Huyện An Dương" => array(

                ),
                "Huyện Tiên Lãng" => array(

                ),
                "Huyện Vĩnh Bảo" => array(

                ),
                "Huyện Cát Hải" => array(

                ),
                "Huyện Bạch Long Vĩ" => array(

                ),
                "Quận Dương Kinh" => array(

                )
            ),
            "Hà Nội" => array(
                "Quận Ba Đình" => array(

                ),
                "Quận Hoàn Kiếm" => array(

                ),
                "Quận Hai Bà Trưng" => array(

                ),
                "Quận Đống Đa" => array(

                ),
                "Quận Tây Hồ" => array(

                ),
                "Quận Cầu Giấy" => array(

                ),
                "Quận Thanh Xuân" => array(

                ),
                "Quận Hoàng Mai" => array(

                ),
                "Quận Long Biên" => array(

                ),
                "Huyện Từ Liêm" => array(

                ),
                "Huyện Thanh Trì" => array(

                ),
                "Huyện Gia Lâm" => array(

                ),
                "Huyện Đông Anh" => array(

                ),
                "Huyện Sóc Sơn" => array(

                ),
                "Quận Hà Đông" => array(

                ),
                "Thị xã Sơn Tây" => array(

                ),
                "Huyện Ba Vì" => array(

                ),
                "Huyện Phúc Thọ" => array(

                ),
                "Huyện Thạch Thất" => array(

                ),
                "Huyện Quốc Oai" => array(

                ),
                "Huyện Chương Mỹ" => array(

                ),
                "Huyện Đan Phượng" => array(

                ),
                "Huyện Hoài Đức" => array(

                ),
                "Huyện Thanh Oai" => array(

                ),
                "Huyện Mỹ Đức" => array(

                ),
                "Huyện Ứng Hoà" => array(

                ),
                "Huyện Thường Tín" => array(

                ),
                "Huyện Phú Xuyên" => array(

                ),
                "Huyện Mê Linh" => array(

                )
            )
        );
        foreach ($data as $cityName => $districtData) {
            // Get id of city
            $cityId = Cities::getModelIdByName($cityName);
            if (!empty($cityId)) {
                Loggers::info("City: $cityName - Id: $cityId", __FUNCTION__, __LINE__);
                // Loop for all districts inside city
                foreach ($districtData as $districtName => $wardData) {
//                    // Create new district
//                    $model = new Districts();
//                    $nameArr = explode("+", $districtName);
//                    $name = $districtName;
//                    if (count($nameArr) == 2) {
//                        $model->id = $nameArr[1];
//                        $name = $nameArr[0];
//                    }
//                    $model->name = $name;
//                    $model->city_id = $cityId;
//                    $model->short_name = CommonProcess::getShortString($name);
//                    $model->status = DomainConst::DEFAULT_STATUS_ACTIVE;
//                    $model->slug = CommonProcess::getSlugString($name);
//                    if ($model->save()) {
//                        foreach ($wardData as $wardName) {
//                            $ward = new Wards();
//                            $ward->district_id = $model->id;
//                            $ward->name = $wardName;
//                            $ward->short_name = CommonProcess::getShortString($wardName);
//                            $ward->status = DomainConst::DEFAULT_STATUS_ACTIVE;
//                            $ward->slug = CommonProcess::getSlugString($wardName);
//                            $ward->save();
//                        }
//                    }
                    $districtId = Districts::getModelIdByName($districtName);
                    if (empty($districtId)) {
                        Loggers::info("Not found district: $districtName", __FUNCTION__, __LINE__);
                        // Create new district
                        $model = new Districts();
                        $nameArr = explode("+", $districtName);
                        $name = $districtName;
                        if (count($nameArr) == 2) {
                            $model->id = $nameArr[1];
                            $name = $nameArr[0];
                        }
                        $model->name = $name;
                        $model->city_id = $cityId;
                        $model->short_name = CommonProcess::getShortString($name);
                        $model->status = DomainConst::DEFAULT_STATUS_ACTIVE;
                        $model->slug = CommonProcess::getSlugString($name);
                        if ($model->save()) {
                            $districtId = $model->id;
                        }
                    } else {
                        Loggers::info("District: $districtName - Id: $districtId", __FUNCTION__, __LINE__);
                    }
                    
                    if (!empty($districtId)) {
                        foreach ($wardData as $wardName) {
                            $ward = new Wards();
                            $ward->district_id = $districtId;
                            $ward->name = $wardName;
                            $ward->short_name = CommonProcess::getShortString($wardName);
                            $ward->status = DomainConst::DEFAULT_STATUS_ACTIVE;
                            $ward->slug = CommonProcess::getSlugString($wardName);
                            $ward->save();
                        }
                    }
                }
                
            } else {
                Loggers::info("Not found city: $cityName", __FUNCTION__, __LINE__);
            }
        }
    }
    
    public static function importDistrictsInCity() {
        $data = array(
            "Đà Nẵng" => array(
                "Quận Hải Châu" => array(
                    "Phường Bình Hiên",
                    "Phường Bình Thuận",
                    "Phường Hải Châu I",
                    "Phường Hải Châu II",
                    "Phường Hòa Cường Bắc",
                    "Phường Hòa Cường Nam",
                    "Phường Hòa Thuận Đông",
                    "Phường Hòa Thuận Tây",
                    "Phường Nam Dương",
                    "Phường Phước Ninh",
                    "Phường Thạch Thang",
                    "Phường Thanh Bình",
                    "Phường Thuận Phước"
                ),
                "Quận Thanh Khê" => array(
                    "Phường An Khê",
                    "Phường Chính Gián",
                    "Phường Hòa Khê",
                    "Phường Tam Thuận",
                    "Phường Tân Chính",
                    "Phường Thạc Gián",
                    "Phường Thanh Khê Đông",
                    "Phường Thanh Khê Tây",
                    "Phường Vĩnh Trung",
                    "Phường Xuân Hà"
                ),
                "Quận Sơn Trà" => array(
                    "Phường Thọ Quang",
                    "Phường Nại Hiên Đông",
                    "Phường Mân Thái",
                    "Phường An Hải Bắc",
                    "Phường Phước Mỹ",
                    "Phường An Hải Tây",
                    "Phường An Hải Đông"
                ),
                "Quận Ngũ Hành Sơn" => array(
                    "Phường Mỹ An",
                    "Phường Khuê Mỹ",
                    "Phường Hoà Quý",
                    "Phường Hoà Hải"
                ),
                "Quận Liên Chiểu" => array(
                    "Phường Hòa Hiệp Bắc",
                    "Phường Hòa Hiệp Nam",
                    "Phường Hòa Khánh Bắc",
                    "Phường Hòa Khánh Nam",
                    "Phường Hòa Minh"
                ),
                "Huyện Hoà Vang" => array(
                    "Xã Hòa Bắc",
                    "Xã Hòa Liên",
                    "Xã Hòa Ninh",
                    "Xã Hòa Sơn",
                    "Xã Hòa Nhơn",
                    "Xã Hòa Phú",
                    "Xã Hòa Phong",
                    "Xã Hòa Châu",
                    "Xã Hòa Tiến",
                    "Xã Hòa Phước",
                    "Xã Hòa Khương"
                ),
                "Quận Cẩm Lệ" => array(
                    "Phường Khuê Trung",
                    "Phường Hòa Phát",
                    "Phường Hòa An",
                    "Phường Hòa Thọ Tây",
                    "Phường Hòa Thọ Đông",
                    "Phường Hòa Xuân"
                ),
                "Huyện Hoàng Sa" => array(

                )
            ),
        );
        foreach ($data as $cityName => $districtData) {
            // Get id of city
            $cityId = Cities::getModelIdByName($cityName);
            if (!empty($cityId)) {
                // Loop for all districts inside city
                foreach ($districtData as $districtName => $wardData) {
                    $districtId = Districts::getModelIdByName($districtName);
                    if (empty($districtId)) {
                        // Create new district
                        $model = new Districts();
                        $nameArr = explode("+", $districtName);
                        $name = $districtName;
                        if (count($nameArr) == 2) {
                            $model->id = $nameArr[1];
                            $name = $nameArr[0];
                        }
                        $model->name = $name;
                        $model->city_id = $cityId;
                        $model->short_name = CommonProcess::getShortString($name);
                        $model->status = DomainConst::DEFAULT_STATUS_ACTIVE;
                        $model->slug = CommonProcess::getSlugString($name);
                        if ($model->save()) {
                            $districtId = $model->id;
                        }
                    }
                    
                    if (!empty($districtId)) {
                        foreach ($wardData as $wardName) {
                            $ward = new Wards();
                            $ward->district_id = $districtId;
                            $ward->name = $wardName;
                            $ward->short_name = CommonProcess::getShortString($wardName);
                            $ward->status = DomainConst::DEFAULT_STATUS_ACTIVE;
                            $ward->slug = CommonProcess::getSlugString($wardName);
                            $ward->save();
                        }
                    }
                }
            }
        }
    }
    
    public static function importCustomer() {
        $data = array(
        );
        
        foreach ($data as $value) {
            $infoArr = array_values($value);
            $customer = new Customers();
            $customer->id = $infoArr[0];
            $customer->name = $infoArr[2];
            if ($infoArr[3] == '1') {
                $customer->gender = DomainConst::GENDER_MALE;
            } else {
                $customer->gender = DomainConst::GENDER_FEMALE;
            }
            if (isset($infoArr[4])) {
               $customer->date_of_birth = $infoArr[4];
            } else {
                $customer->date_of_birth = "01/01/2000";
            }
            $customer->phone = isset($infoArr[8]) ? $infoArr[8] : '';
            $customer->house_numbers = isset($infoArr[5]) ? $infoArr[5] : '';
            $customer->city_id = isset($infoArr[6]) ? $infoArr[6] : '';
            $customer->district_id = isset($infoArr[7]) ? $infoArr[7] : '';
            $customer->status = DomainConst::DEFAULT_STATUS_ACTIVE;
            if ($customer->save()) {
                OneMany::insertOne('1', $customer->id, OneMany::TYPE_AGENT_CUSTOMER);
                $medicalRecord = new MedicalRecords();
                $medicalRecord->customer_id = $customer->id;
                $medicalRecord->record_number = isset($infoArr[1]) ? $infoArr[1] : '';
                $medicalRecord->save();
            }
        }
    }
    
    public static function importScheduleTime() {
        $data = array(
            array(1, '08:00'),
            array(2, '08:15'),
            array(3, '08:30'),
            array(4, '08:45'),
            array(5, '09:00'),
            array(6, '09:15'),
            array(7, '09:30'),
            array(8, '09:45'),
            array(9, '10:00'),
            array(10, '10:15'),
            array(11, '10:30'),
            array(12, '10:45'),
            array(13, '11:00'),
            array(14, '11:15'),
            array(15, '11:30'),
            array(16, '11:45'),
            array(17, '12:00'),
            array(18, '12:15'),
            array(19, '12:30'),
            array(20, '12:45'),
            array(21, '13:00'),
            array(22, '13:15'),
            array(23, '13:30'),
            array(24, '13:45'),
            array(25, '14:00'),
            array(26, '14:15'),
            array(27, '14:30'),
            array(28, '14:45'),
            array(29, '15:00'),
            array(30, '15:15'),
            array(31, '15:30'),
            array(32, '15:45'),
            array(33, '16:00'),
            array(34, '16:15'),
            array(35, '16:30'),
            array(36, '16:45'),
            array(37, '17:00'),
            array(38, '17:15'),
            array(39, '17:30'),
            array(40, '17:45'),
            array(41, '18:00'),
            array(42, '18:15'),
            array(43, '18:30'),
            array(44, '18:45'),
            array(45, '19:00'),
            array(46, '19:15'),
            array(47, '19:30'),
            array(48, '19:45'),
            array(49, '20:00'),
            array(50, '20:15'),
            array(51, '20:30'),
            array(52, '20:45'),
            array(53, '21:00'),
            array(54, '21:15'),
            array(55, '21:30'),
            array(56, '21:45'),
            array(57, '22:00'),
        
            array(2, '08:05'),
            array(3, '08:10'),
            array(4, '08:20'),
            array(4, '08:25'),
            array(3, '08:35'),
            array(3, '08:40'),
            array(4, '08:50'),
            array(4, '08:55'),
            array(5, '09:05'),
            array(5, '09:10'),
            array(5, '09:20'),
            array(5, '09:25'),
            array(5, '09:35'),
            array(5, '09:40'),
            array(5, '09:50'),
            array(5, '09:55'),
            array(5, '10:05'),
            array(5, '10:10'),
            array(5, '10:20'),
            array(5, '10:25'),
            array(5, '10:35'),
            array(5, '10:40'),
            array(5, '10:50'),
            array(5, '10:55'),
            array(5, '11:05'),
            array(5, '11:10'),
            array(5, '11:20'),
            array(5, '11:25'),
            array(5, '11:35'),
            array(5, '11:40'),
            array(5, '11:50'),
            array(5, '11:55'),
            array(5, '12:05'),
            array(5, '12:10'),
            array(5, '12:20'),
            array(5, '12:25'),
            array(5, '12:35'),
            array(5, '12:40'),
            array(5, '12:50'),
            array(5, '12:55'),
            array(5, '13:05'),
            array(5, '13:10'),
            array(5, '13:20'),
            array(5, '13:25'),
            array(5, '13:35'),
            array(5, '13:40'),
            array(5, '13:50'),
            array(5, '13:55'),
            array(5, '14:05'),
            array(5, '14:10'),
            array(5, '14:20'),
            array(5, '14:25'),
            array(5, '14:35'),
            array(5, '14:40'),
            array(5, '14:50'),
            array(5, '14:55'),
            array(5, '15:05'),
            array(5, '15:10'),
            array(5, '15:20'),
            array(5, '15:25'),
            array(5, '15:35'),
            array(5, '15:40'),
            array(5, '15:50'),
            array(5, '15:55'),
            array(5, '16:05'),
            array(5, '16:10'),
            array(5, '16:20'),
            array(5, '16:25'),
            array(5, '16:35'),
            array(5, '16:40'),
            array(5, '16:50'),
            array(5, '16:55'),
            array(5, '17:05'),
            array(5, '17:10'),
            array(5, '17:20'),
            array(5, '17:25'),
            array(5, '17:35'),
            array(5, '17:40'),
            array(5, '17:50'),
            array(5, '17:55'),
            array(5, '18:05'),
            array(5, '18:10'),
            array(5, '18:20'),
            array(5, '18:25'),
            array(5, '18:35'),
            array(5, '18:40'),
            array(5, '18:50'),
            array(5, '18:55'),
            array(5, '19:05'),
            array(5, '19:10'),
            array(5, '19:20'),
            array(5, '19:25'),
            array(5, '19:35'),
            array(5, '19:40'),
            array(5, '19:50'),
            array(5, '19:55'),
            array(5, '20:05'),
            array(5, '20:10'),
            array(5, '20:20'),
            array(5, '20:25'),
            array(5, '20:35'),
            array(5, '20:40'),
            array(5, '20:50'),
            array(5, '20:55'),
            array(5, '21:05'),
            array(5, '21:10'),
            array(5, '21:20'),
            array(5, '21:25'),
            array(5, '21:35'),
            array(5, '21:40'),
            array(5, '21:50'),
            array(5, '21:55'),
        );
        
        foreach ($data as $value) {
            $infoArr = array_values($value);
            $time = new ScheduleTimes();
//            $time->id = $infoArr[0];
            $time->name = $infoArr[1];
            $time->save();
        }
    }
    
    public static function importMedicine() {
        $data = array(
            array(1, 'Amoxicilline250mg', 'Amoxicilline 250mg', '250mg', 1, '', 1, NULL, 1, 0, 0, ''),
            array(2, 'Amoxicilline500mg', 'Amoxicilline 500mg', '500mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(3, 'Azithromycin500mg', 'azthromycin 500mg', '500mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(4, 'Cephalexin250mg', 'Cephalexin 250mg', '250mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(5, 'Cephalexin 500mg', 'Cephalexin 500mg', '500mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(6, 'Erythromycin 500mg', 'Erythromycin 500mg', '500mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(7, 'Clindamycin 300mg', 'Clindamycin 300mg', '300mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(8, 'Spiramycin 500mg', 'Spiramycin 500mg', '500mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(9, 'Roxithromycin 200mg', 'Roxithromycin 200mg', '200mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(10, 'Rodogyl', 'Rodogyl', NULL, 1, 'Spiramycin + Metronidazole 125mg', 1, NULL, 1, NULL, NULL, ''),
            array(11, 'Cephalosporin 500mg', 'Cephalosporin 500mg', '500mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(12, 'Metronidazole 250mg', 'Metronidazole 250mg', '250mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(13, 'Doxycycline 100mg', 'Doxycycline 100mg', '100mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(14, 'Klamentine 625mg', 'Klamentine 625mg', '625mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(15, 'Klamentine 1g', 'Klamentine 1g', '1g', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(16, 'Klavunamox 625mg', 'Klavunamox 625mg', '625mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(17, 'Klavunamox 1g', 'Klavunamox 1g', '1g', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(18, 'Augmentine 625mg', 'Augmentine 625mg', '625mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(19, 'Augmentine 1g', 'Augmentine 1g', '1g', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(20, 'Cefaclor 250mg', 'Cefaclor 250mg', '250mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(21, 'Cefaclor 500mg', 'Cefaclor 500mg', '500mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(22, 'Cefuroxime 250mg', 'Cefuroxime 250mg', '250mg', 1, NULL, 1, NULL, 1, NULL, NULL, ''),
            array(23, 'Nystatine 200.000 UI', 'Nystatine 200.000UI', '200.000UI', 1, NULL, 2, NULL, 5, NULL, NULL, ''),
            array(24, 'Acyclovir 200mg', 'Acyclovir 200mg', '200mg', 1, NULL, 1, NULL, 6, NULL, NULL, ''),
            array(25, 'Acyclovir 800mg', 'Acyclovir 800mg', '800mg', 1, NULL, 1, NULL, 6, NULL, NULL, ''),
            array(26, 'Acyclovir 5%', 'Acyclovir 5%', '5%', 4, NULL, 4, NULL, 6, NULL, NULL, ''),
            array(27, 'Ibuprofen 200mg', 'Ibuprofen 200mg', '200mg', 1, NULL, 1, NULL, 8, NULL, NULL, ''),
            array(28, 'Ibuprofen 400mg', 'Ibuprofen 400mg', '400mg', 1, NULL, 1, NULL, 8, NULL, NULL, ''),
            array(29, 'Diclofenac 50mg', 'Diclofenac 50mg', '50mg', 1, NULL, 1, NULL, 8, NULL, NULL, ''),
            array(30, 'Ketoprofen 50mg', 'Ketoprofen 50mg', '50mg', 1, NULL, 1, NULL, 8, NULL, NULL, ''),
            array(31, 'Indomethacin 50mg', 'Indomethacin 50mg', '50mg', 1, NULL, 1, NULL, 8, NULL, NULL, ''),
            array(32, 'Prednisolone 5mg', 'Prednisolone 5mg', '5mg', 1, NULL, 1, NULL, 2, NULL, NULL, ''),
            array(33, 'Medrol 16mg', 'Medrol16mg', '16mg', 1, NULL, 1, NULL, 2, NULL, NULL, ''),
            array(34, 'Alpha Chymotrypsin', 'Alpha Chymotrypsin', NULL, 1, NULL, 2, NULL, 2, NULL, NULL, ''),
            array(35, 'Paracetamol 250mg', 'Paracetamol 250mg', '250mg', 1, NULL, 1, NULL, 3, NULL, NULL, ''),
            array(36, 'Paracetamol 250mg', 'Paracetamol 250mg', '250mg', 3, NULL, 1, NULL, 3, NULL, NULL, ''),
            array(37, 'Paracetamol 500mg', 'Paracetamol 500mg', '500mg', 1, NULL, 1, NULL, 3, NULL, NULL, ''),
            array(38, 'Efferalgan 500mg', ' Efferalgan 500mg', '500mg', 1, NULL, 1, NULL, 3, NULL, NULL, ''),
            array(39, 'Vitamin C 1g', 'Vitamin C 1g', '1g', 1, NULL, 1, NULL, 4, NULL, NULL, ''),
            array(40, 'Vitamin 3B(B1,B6,B12)', 'Vitamin 3B', NULL, 1, NULL, 1, NULL, 4, NULL, NULL, ''),
            array(41, 'Vitamin PP', 'Vitamin PP', NULL, 1, NULL, 1, NULL, 4, NULL, NULL, ''),
            array(42, 'Fecet 180mg', 'Fecet 180mg', '180mg', 1, 'fexofenadine', 1, NULL, 7, NULL, NULL, ''),
            array(43, 'Cezil 10mg', 'Cezil 10mg', '10mg', 1, 'Cetirizine', 1, NULL, 7, NULL, NULL, ''),
            array(44, 'Fexofenadine 60mg', 'Fexofenadine 60mg', '60mg', 1, 'Fexofenadine', 1, NULL, 7, NULL, NULL, ''),
            array(45, 'Fexofenadine 120mg', 'Fexofenadine 120mg', '120mg', 1, 'Fexofenadine', 1, NULL, 7, NULL, NULL, ''),
            array(46, 'Fexofenadine 180mg', 'Fexofenadine 180mg', '180mg', 1, 'Fexofenadine', 1, NULL, 7, NULL, NULL, ''),
            array(47, 'Telfast 120mg', 'Telfast 120mg', '120mg', 1, 'Fexofenadine Chlorhydrate 60mg', 1, NULL, 7, NULL, NULL, ''),
            array(48, 'Telfast 60mg', 'Telfast 60mg', '60mg', 1, 'fexofenadine Chlorhydrate 60mg', 1, NULL, 7, NULL, NULL, ''),
            array(49, 'Chlorexhidine Gluconate 0.12%', 'Chlorexhidine Gluconate 0.12%', '0.12%', 5, NULL, 5, NULL, 4, NULL, NULL, ''),
            array(50, 'Omez 20mg', 'Omez 20mg', '20mg', 1, 'Omeprazole', 1, NULL, 4, NULL, NULL, ''),
            array(51, 'Transamin 500mg', 'Transamin 500mg', '500mg', 1, NULL, 1, NULL, 4, NULL, NULL, '')
        );
        foreach ($data as $value) {
            $infoArr = array_values($value);
            $model = new Medicines();
            $model->id = $infoArr[0];
            $model->name = $infoArr[2];
            $model->code = $infoArr[1];
            $model->content = $infoArr[3];
            $model->unit_id = isset($infoArr[4]) ? $infoArr[4] : 1;
            $model->active_ingredient = isset($infoArr[5]) ? $infoArr[5] : '';
            $model->use_id = isset($infoArr[6]) ? $infoArr[6] : 1;
            $model->manufacturer = isset($infoArr[7]) ? $infoArr[7] : '';
            $model->type_id = isset($infoArr[8]) ? $infoArr[8] : 1;
            $model->buy_price = isset($infoArr[9]) ? $infoArr[9] : '0';
            $model->sell_price = isset($infoArr[10]) ? $infoArr[10] : '0';
            $model->save();
        }
    }
    
    public static function importDiagnosis() {
        $data = array(
            array(1, 'K00.0', 'Tật không răng', 'Anodontia', 0),
            array(2, 'K00.1', 'Răng thừa', 'Supernumerary teeth', 0),
            array(3, 'K00.2', 'Bất thường kích thước và hình dạng răng', 'Abnormalities of size and form of teeth', 0),
            array(4, 'K00.3', 'Răng lốm đốm', 'Mottled teeth', 0),
            array(5, 'K00.4', 'Rối loạn quá trình hình thành răng', 'Disturbances in tooth formation', 0),
            array(6, 'K00.5', 'Rối loạn di truyền cấu trúc răng, không phân loại nơi khác', 'Hereditary disturbances in tooth structure, not elsewhere classified', 0),
            array(7, 'K00.6', 'Rối loạn mọc răng', 'Disturbances in tooth eruption', 0),
            array(8, 'K00.8', 'Rối loạn khác về phát triển răng', 'Other disorders of tooth development', 0),
            array(9, 'K01', 'Răng mọc kẹt và răng ngầm', 'Embedded and impacted teeth', 0),
            array(10, 'K02', 'Sâu răng', 'Dental caries', 0),
            array(11, 'K03', 'Bệnh mô cứng khác của răng', 'Other diseases of hard tissues of teeth', 0),
            array(12, 'K04', 'Bệnh tủy và mô quanh chóp ', 'Diseases of pulp and periapical tissues', 0),
            array(13, 'K05', 'Viêm nướu và bệnh nha chu', 'Gingivitis and periodontal diseases', 0),
            array(14, 'K07', 'Dị dạng răng-mặt [bao gồm lệch lạc khớp cắn]', 'Dentofacial anomalies [including malocclusion]', 0),
            array(15, 'K09', 'Nang vùng miệng, không phân loại nơi khác', 'Cysts of oral region, not elsewhere classified', 0),
            array(16, 'K10', 'Bệnh khác của xương hàm', 'Other diseases of jaws', 0),
            array(17, 'K11', 'Bệnh tuyến nước bọt', 'Diseases of salivary glands', 0),
            array(18, 'K12', 'Viêm miệng và sang thương liên quan', 'Stomatitis and related lesions', 0),
            array(19, 'K13', 'Bệnh khác của môi và niêm mạc miệng', 'Other diseases of lip and oral mucosa', 0),
            array(20, 'K14', 'Bệnh của lưỡi', 'Diseases of tongue', 0),
            array(21, 'C00', 'U ác của môi', 'Malignant neoplasm of lip', 0),
            array(22, 'C01', 'U ác của đáy lưỡi', 'Malignant neoplasm of base of tongue', 0),
            array(23, 'C02', 'U ác của phần khác và không xác định của lưỡi', 'Malignant neoplasm of other and unspecified parts of tongue', 0),
            array(24, 'C03', 'U ác nướu răng', 'Malignant neoplasm of gum', 0),
            array(25, 'C04', 'U ác sàn miệng', 'Malignant neoplasm of floor of mouth', 0),
            array(26, 'C05', 'U ác khẩu cái', 'Malignant neoplasm of palate', 0),
            array(27, 'C06', 'U ác của phần khác và không xác định của miệng', 'Malignant neoplasm of other and unspecified parts of mouth', 0),
            array(28, 'C41', 'U ác của xương và sụn khớp ở vị trí khác và không xác định', 'Malignant neoplasm of bone and articular cartilage of other and unspecified sites', 0),
            array(29, 'C43', 'Melanom và các u ác tính khác ở da', 'Melanoma  and other malignant neoplasms of skin ', 0),
            array(30, NULL, 'U ác tính của mô mềm và trung mô', 'Malignant neoplasms of mesothelial and soft tissue', 0),
            array(31, 'C47', 'U ác của dây thần kinh ngoại biên và hệ thần kinh tự chủ ', 'Malignant neoplasm of peripheral nerves and autonomic nervous system', 0),
            array(32, 'C79', 'U ác thứ phát vị trí khác', 'Secondary malignant neoplasm of other sites', 0),
            array(33, 'D00.0', 'Carcinom tại chỗ của Môi, khoang miệng và hầu', 'Carcinoma in situ of lip, oral cavity and pharynx', 0),
            array(34, 'D03', 'Melanom tại chỗ', 'Melanoma in situ', 0),
            array(35, NULL, 'U lành của miệng và hầu', NULL, 0),
            array(36, NULL, 'U lành của miệng và hầu', 'Benign neopiasm of mouth and pharynx', 0),
            array(37, NULL, 'U lành của xương và sụn khớp', 'Benign neoplasm of bone and articular cartilage', 0),
            array(1, 'K00.0', 'Tật không răng', 'Anodontia', 1),
            array(2, 'K00.00', 'Tật không răng một phần (sự thiếu răng) (tật thiếu răng)', 'Partial anodontia [hypodontia] [oligodontia]', 1),
            array(3, 'K00.01', 'Tật không răng toàn bộ', 'Total anodontia', 1),
            array(4, 'K00.1', 'Răng thừa', 'Supernumerary teeth', 2),
            array(5, 'K00.10', 'Vùng răng cửa, răng nanh', 'Incisor and canine regions', 2),
            array(6, '', 'Mesiodens (răng dư kẻ giữa)', 'Mesiodens', 2),
            array(7, 'K00.11', 'Vùng răng cối nhỏ', 'Premolar region', 2),
            array(8, 'K00.12', 'Vùng răng cối', 'Molar region', 2),
            array(9, '', 'Răng cối phía xa', 'Distomolar', 2),
            array(10, '', 'Răng cối thứ tư', 'Fourth molar', 2),
            array(11, '', 'Răng cối kế cận', 'Paramolar', 2),
            array(12, 'K00.19', 'Răng thừa, không xác định ', 'Supernumerary teeth, unspecified', 2),
            array(13, 'K00.2', 'Bất thường kích thước và hình dạng răng', 'Abnormalities of size and form of teeth', 3),
            array(14, 'K00.20', 'Tật răng to', 'Macrodontia', 3),
            array(15, 'K00.21', 'Tật răng nhỏ', 'Microdontia', 3),
            array(16, 'K00.22', 'Răng dung hợp', 'Concrescence', 3),
            array(17, 'K00.23', 'Răng dính và răng sinh đôi', 'Fusion and gemination, Schizodontia, Synodontia', 3),
            array(18, 'K00.24', 'Núm mặt nhai, ngoại trừ núm carabelli ', 'Dens evaginatus [occlusal tuberculum]', 3),
            array(19, 'K00.25', 'Lồng răng (răng trong răng) (u răng phình to) và dị dạng răng cửa', 'Dens invaginatus [\"dens in dente\"] [dilated odontoma] and incisor anomalies', 3),
            array(20, '', 'Răng có rãnh phía khẩu cái', 'Palatal groove', 3),
            array(21, '', 'Răng cửa hình chêm (hình nón)', 'Peg-shaped [conical] incisors', 3),
            array(22, '', 'Răng cửa hình xẻng', 'Shovel-shaped incisors', 3),
            array(23, '', 'Răng cửa hình chữ T', 'T-shaped incisors', 3),
            array(24, 'K00.26', 'Răng dạng tiền cối ', 'Premolarization', 3),
            array(25, 'K00.27', 'Núm bất thường và hạt trai men ', 'Abnormal tubercula and enamel pearls [enameloma]', 3),
            array(26, 'K00.28', 'Răng buồng tủy to (răng bò mộng)', 'Taurodontism', 3),
            array(27, 'K00.3', 'Răng lốm đốm', 'Mottled teeth', 4),
            array(28, 'K00.30', 'Men răng lốm đốm do nhiễm fluor (răng nhiễm fluor)', 'Endemic (fluoride) mottling of enamel [dental fluorosis]', 4),
            array(29, 'K00.31', 'Men răng lốm đốm không do fluor (men răng bị đục không phải do fluor)', 'Non-endemic mottling of enamel [non-fluoride enamel opacities]', 4),
            array(30, 'K00.39', 'Răng lốm đốm, không xác định ', 'Mottled teeth, unspecified', 4),
            array(31, 'K00.4', 'Rối loạn quá trình hình thành răng', 'Disturbances in tooth formation', 5),
            array(32, 'K00.40', 'Thiểu sản men', 'Enamel hypoplasia', 5),
            array(33, 'K00.44', 'Răng gập góc (vùng cổ răng)', 'Dilaceration', 5),
            array(34, 'K00.45', 'Loạn sản răng', 'Odontodysplasia [regional odontodysplasia]', 5),
            array(35, 'K00.5', 'Rối loạn di truyền cấu trúc răng, không phân loại nơi khác', 'Hereditary disturbances in tooth structure, not elsewhere classified', 6),
            array(36, 'K00.50', 'Chứng sinh men bất toàn', 'Amelogenesis imperfecta', 6),
            array(37, 'K00.51', 'Chứng sinh ngà răng bất toàn', 'Dentinogenesis imperfecta', 6),
            array(38, 'K00.52', 'Chứng sinh răng bất toàn ', 'Odontogenesis imperfecta', 6),
            array(39, '', 'Răng hình vỏ sò', 'Shell teeth', 6),
            array(40, 'K00.6', 'Rối loạn mọc răng', 'Disturbances in tooth eruption', 7),
            array(41, 'K00.62', 'Mọc răng sớm', 'Premature eruption [dentia praecox]', 7),
            array(42, 'K00.63', 'Răng sữa không thay', 'Retained [persistent] primary [deciduous] teeth', 7),
            array(43, 'K00.64', 'Chậm mọc răng ', 'Late eruption', 7),
            array(44, 'K00.65', 'Răng sữa rụng sớm', 'Premature shedding of primary [deciduous] teeth', 7),
            array(45, 'K00.8', 'Rối loạn khác về phát triển răng', 'Other disorders of tooth development', 8),
            array(46, 'K00.83', 'Sự đổi màu trong quá trình hình thành do nhiễm Tetracyllin', 'Colour changes during tooth formation due to tetracyclines', 8),
            array(47, 'K01', 'Răng mọc kẹt và răng ngầm', 'Embedded and impacted teeth', 9),
            array(48, 'K01.0', 'Răng ngầm', 'Embedded teeth', 9),
            array(49, '', 'Răng ngầm là răng không mọc lên được dù không có răng khác cản trở ', 'An embedded tooth is a tooth that has failed to erupt without obstruction by another tooth', 9),
            array(50, 'K01.1', 'Răng mọc kẹt', 'Impacted teeth', 9),
            array(51, '', 'Răng mọc kẹt là răng không mọc lên được do răng khác cản trở ', 'An impacted tooth is a tooth that has failed to erupt because of obstruction by another tooth', 9),
            array(52, 'K01.10', 'Răng cửa hàm trên', 'Maxillary incisor', 9),
            array(53, 'K01.11', 'Răng cửa hàm dưới', ' Mandibular incisor', 9),
            array(54, 'K01.12', 'Răng nanh hàm trên', 'Maxillary canine', 9),
            array(55, 'K01.13', 'Răng nanh hàm dưới', 'Mandibular canine', 9),
            array(56, 'K01.14', 'Răng cối nhỏ hàm trên', 'Maxillary premolar', 9),
            array(57, 'K01.15', 'Răng cối nhỏ hàm dưới', 'Mandibular premolar', 9),
            array(58, 'K01.16', 'Răng cối hàm trên', 'Maxillary molar', 9),
            array(59, 'K01.17', 'Răng cối hàm dưới', 'Mandibular molar', 9),
            array(60, 'K01.18', 'Răng thừa', 'Supernumerary tooth', 9),
            array(61, 'K02', 'Sâu răng', 'Dental caries', 10),
            array(62, 'K02.0', 'Sâu giới hạn ở men', 'Caries limited to enamel', 10),
            array(63, '', 'Sang thương lốm đốm trắng (sâu răng khởi phát)', 'White spot lesion [initial caries]', 10),
            array(64, 'K02.1', 'Sâu ngà', 'Caries of dentine', 10),
            array(65, 'K02.2', 'Sâu xi măng ', 'Caries of cementum', 10),
            array(66, 'K02.3', 'Sâu răng ngưng tiến triển', 'Arrested dental caries', 10),
            array(67, 'K02.4', 'Răng siết (răng tiêu ngót)', 'Odontoclasia', 10),
            array(68, 'K03', 'Bệnh mô cứng khác của răng', 'Other diseases of hard tissues of teeth', 11),
            array(69, 'K03.0', 'Mòn răng quá mức', 'Excessive attrition of teeth', 11),
            array(70, 'K03.00', 'Mặt nhai', 'Occlusal', 11),
            array(71, 'K03.01', 'Mặt tiếp cận', 'Approximal', 11),
            array(72, 'K03.1', 'Mài mòn răng (nguyên nhân cơ học)', 'Abrasion of teeth', 11),
            array(73, 'K03.10', 'Do thuốc chải răng', 'Dentifrice', 11),
            array(74, '', 'Khuyết hình chêm (nêm)', 'Wedge defect NOS', 11),
            array(75, 'K03.11', 'Do thói quen', 'Habitual ', 11),
            array(76, 'K03.12', 'Do nghề nghiệp', 'Occupational ', 11),
            array(77, 'K03.13', 'Do tập quán', 'Traditional ', 11),
            array(78, 'K03.2', 'Ăn mòn răng (nguyên nhân hóa học)', 'Erosion of teeth', 11),
            array(79, 'K03.20', 'Do nghề nghiệp', 'Occupational ', 11),
            array(80, 'K03.21', 'Do trớ hay nôn mửa kéo dài', 'Due to persistent regurgitating of vomiting', 11),
            array(81, 'K03.22', 'Do ăn kiêng', 'Due to diet', 11),
            array(82, 'K03.23', 'Do thuốc và dược phẩm ', 'Due to drugs and medicaments', 11),
            array(83, 'K03.24', 'Tự phát', 'Idiopathic', 11),
            array(84, 'K03.3', 'Tiêu răng bệnh lý', 'Pathological resorption of teeth', 11),
            array(85, 'K03.30', 'Ngoại tiêu', 'External ', 11),
            array(86, 'K03.31', 'Nội tiêu (u hạt trong răng) (điểm hồng)', 'Internal [internal granuloma] [pink spot]', 11),
            array(87, 'K03.4', 'Tăng sinh xi măng', 'Hypercementosis', 11),
            array(88, '', 'Ngoại trừ: Chứng dày xê-măng trong bệnh Paget', 'Excludes: hypercementosis in Paget\'s disease', 11),
            array(89, 'K03.5', 'Cứng khớp răng', 'Ankylosis of teeth', 11),
            array(90, 'K03.6', 'Chất lắng đọng [tích tụ] trên răng', 'Deposits [accretions] on teeth', 11),
            array(91, '', 'Bao gồm: Vết dính KXĐ', 'Includes: staining of teeth NOS', 11),
            array(92, 'K03.60', 'Màng sắc tố', 'Pigmented film', 11),
            array(93, 'K03.61', 'Do thói quen hút thuốc lá', 'Due to tobaco habit', 11),
            array(94, 'K03.62', 'Do thói quen nhai trầu', 'Due to betel-chewing habit', 11),
            array(95, 'K03.63', 'Các chất dính mềm thô khác', 'Other gross soft deposits', 11),
            array(96, '', 'Bựa răng', 'Materia alba', 11),
            array(97, 'K03.64', 'Vôi răng trên nướu', 'Supragingival calculus', 11),
            array(98, 'K03.65', 'Vôi răng dưới nướu', 'Subgingival calculus', 11),
            array(99, 'K03.66', 'Mảng bám răng', 'Dental plaque', 11),
            array(100, 'K03.7', 'Đổi màu mô cứng của răng sau mọc ', 'Posteruptive colour changes of dental hard tissues', 11),
            array(101, 'K03.70', 'Do kim loại & hợp kim', 'Due to metals and metallic compounds', 11),
            array(102, 'K03.71', 'Do tủy xuất huyết', 'Due to pulpal bleeding', 11),
            array(103, 'K03.72', 'Do thói quen ăn nhai: trầu, thuốc lá', 'Due to chewing habit: betel, tobaco', 11),
            array(104, 'K03.8', 'Bệnh khác của mô cứng của răng', 'Other specified diseases of hard tissues of teeth', 11),
            array(105, 'K03.80', 'Ngà quá cảm', 'Sensitive dentine', 11),
            array(106, 'K03.81', 'Biến đổi men răng do tia xạ', 'Changes in enamel due to irradiation', 11),
            array(107, 'K04', 'Bệnh tủy và mô quanh chóp ', 'Diseases of pulp and periapical tissues', 12),
            array(108, 'K04.0', 'Viêm tủy răng', 'Pulpitis', 12),
            array(109, 'K04.00', 'Khởi phát (sung huyết tủy)', 'Initial (hyperaemia)', 12),
            array(110, 'K04.01', 'Cấp tính', 'Acute', 12),
            array(111, 'K04.02', 'Mưng mủ (áp xe tủy)', 'Suppurative [pulpal abscess]', 12),
            array(112, 'K04.03', 'mạn tính', 'Chronic', 12),
            array(113, 'K04.04', 'mạn kèm abcess', 'Chronic, ulcerative', 12),
            array(114, 'K04.05', 'mạn, tăng sản (polyp tủy)', 'Chronic, hyperplastic [pulpal polyp]', 12),
            array(115, 'K04.1', 'Hoại tử tủy', 'Necrosis of pulp', 12),
            array(116, '', 'Hoại thư tủy', 'Pulpal gangrene', 12),
            array(117, 'K04.2', 'Thoái hoá tủy', 'Pulp degeneration', 12),
            array(118, '', 'Sạn tủy', 'Denticles', 12),
            array(119, '', 'Vôi hóa tủy', 'Pulpal calcification', 12),
            array(120, 'K04.3', 'Hình thành mô cứng bất thường trong tủy', 'Abnormal hard tissue formation in pulp', 12),
            array(121, 'K04.3X', 'Ngà thứ phát hay ngà bất thường', 'Secondary or irregular dentine', 12),
            array(122, 'K04.4', 'Viêm quanh chóp cấp do tủy', 'Acute apical periodontitis of pulpal origin', 12),
            array(123, '', 'Viêm quanh chóp cấp KXĐ', 'Acute apical periodontitis NOS', 12),
            array(124, 'K04.5', 'Viêm quanh chóp mạn', 'Chronic apical periodontitis', 12),
            array(125, '', 'U hạt chóp răng', 'Apical granuloma', 12),
            array(126, 'K04.6', 'Áp xe quanh chóp có tạo đường dò', 'Periapical abscess with sinus', 12),
            array(127, '', 'Bao gồm: Áp xe răng', 'Includes: dental abscess with sinus', 12),
            array(128, '', 'Áp xe xương ổ răng', 'dentoaveolar abscess with sinus', 12),
            array(129, '', 'Áp xe nha chu do tủy', 'periodontal abscess of pulpal origin', 12),
            array(130, 'K04.60', 'Lỗ dò ra xoang hàm', 'Sinus to maxillary antrum', 12),
            array(131, 'K04.61', 'Lỗ dò ra khoang mũi', 'Sinus to nasal cavity', 12),
            array(132, 'K04.62', 'Lỗ dò ra khoang miệng', 'Sinus to oral cavity', 12),
            array(133, 'K04.63', 'Lỗ dò ra da', 'Sinus to skin', 12),
            array(134, 'K04.69', 'Áp xe quanh chóp có đường dò, không xác định ', 'Periapical abscess with sinus, unspecified', 12),
            array(135, 'K04.7', 'Áp xe quanh chóp không tạo đường dò ', 'Periapical abscess without sinus', 12),
            array(136, '', 'Áp xe răng', 'Dental abscess without sinus', 12),
            array(137, '', 'Áp xe xương ổ răng', 'Dentoaveolar abscess without sinus', 12),
            array(138, '', 'Áp xe nha chu do tủy', 'periodontal abscess of pulpal origin', 12),
            array(139, '', 'Áp xe quanh chóp không liên quan tới lỗ dò', 'Periapical abscess with no reference to sinus', 12),
            array(140, 'K04.8', 'Nang chân răng ', 'Radicular cyst', 12),
            array(141, 'K04.80', 'Nang chóp răng và bên răng', 'Apical and lateral ', 12),
            array(142, 'K04.81', 'Nang lưu sót', 'Residual ', 12),
            array(143, 'K04.82', 'Viêm quanh răng', 'Inflammatory paradental ', 12),
            array(144, 'K05', 'Viêm nướu và bệnh nha chu', 'Gingivitis and periodontal diseases', 13),
            array(145, '', 'Bao gồm: Bệnh vùng sóng hàm ', 'Includes: disease of edentulous alveolar ridge', 13),
            array(146, 'K05.0', 'Viêm nướu cấp', 'Acute gingivitis', 13),
            array(147, 'K05.00', 'Viêm miệng nướu cấp do liên cầu', 'Acute streptococcal gingivostomatitis', 13),
            array(148, 'K05.08', 'Viêm nướu cấp đặc hiệu khác', 'Other specified acute gingivitis', 13),
            array(149, 'K05.09', 'Viêm nướu cấp, không xác định ', 'Acute gingivitis, unspecified ', 13),
            array(150, 'K05.1', 'Viêm nướu mạn', 'Chronic gingivitis', 13),
            array(151, 'K05.10', 'Viêm nướu viền đơn giản', 'Simple marginal', 13),
            array(152, 'K05.11', 'Viêm nướu tăng sinh ', 'Hyperplastic', 13),
            array(153, 'K05.12', 'Viêm nướu lở loét', 'Ulcerative', 13),
            array(154, 'K05.13', 'Viêm nướu tróc vảy', 'Desquamative', 13),
            array(155, 'K05.18', 'Viêm nướu mạn đặc hiệu khác', 'Other specified chronic gingivitis', 13),
            array(156, 'K05.2', 'Viêm nha chu cấp', 'Acute periodontitis', 13),
            array(157, 'K05.20', 'Áp xe nha chu [áp xe quanh răng] do nướu không có lỗ dò', 'Periodontal abscess [parodontal abscess] of gingival origin without sinus', 13),
            array(158, '', 'Áp xe nha chu do nướu không liên quan đến lỗ dò', 'Periodontal abscess of gingival origin with no referencence to sinus', 13),
            array(159, 'K05.21', 'Áp xe nha chu [Áp xe quanh răng] do nướu có lỗ dò', 'Periodontal abscess [parodontal abscess] of gingival origin with sinus', 13),
            array(160, 'K05.22', 'Viêm quanh thân răng cấp', 'Acute pericoronitis', 13),
            array(161, 'K05.28', 'Viêm nha chu cấp đặc hiệu khác', 'Other specified acute periodontitis', 13),
            array(162, 'K05.3', 'Viêm nha chu mạn', 'Chronic periodontitis', 13),
            array(163, 'K05.30', 'Viêm nha chu mạn phức tạp ', 'Simple ', 13),
            array(164, 'K05.31', 'Viêm nha chu mạn đơn giản', 'Complex', 13),
            array(165, 'K05.32', 'Viêm quanh thân răng mạn', 'Chronic pericoronitis', 13),
            array(166, 'K05.33', 'Viêm nha chu mạn thể nang dày', 'Thickened follicle', 13),
            array(167, 'K05.38', 'Viêm nha chu mạn đặc hiệu khác', 'Other specified chronic periodontitis', 13),
            array(168, 'K05.4', 'Suy nha chu', 'Periodontosis', 13),
            array(169, '', 'Suy nha chu ở tuổi vị thành niên', 'Juvenile periodontosis', 13),
            array(170, 'K05.5', 'Bệnh nha chu', 'Other periodontal diseases', 13),
            array(171, 'K05.6', 'Bệnh nha chu, không xác định', 'Periodontal disease, unspecified', 13),
            array(172, 'K06', 'Rối loạn khác của nướu và sóng hàm ', 'Other disorders of gingiva and edentulous alveolar ridge', 13),
            array(173, 'K06.0', 'Tụt nướu', 'Gingival recession', 13),
            array(174, '', 'Bao gồm: Sau nhiễm khuẩn', 'Includes: postinfective', 13),
            array(175, '', 'Sau phẫu thuật', 'postoperative', 13),
            array(176, 'K06.00', 'Khu trú', 'Localized', 13),
            array(177, 'K06.01', 'Toàn thể', 'Generalized', 13),
            array(178, 'K06.1', 'Phì đại nướu', 'Gingival enlargement', 13),
            array(179, '', 'Bao gồm: vùng lồi cùng hàm trên ', 'Includes: tuberosity', 13),
            array(180, 'K06.10', 'Bệnh sợi nướu', 'Gingival fibromatosis', 13),
            array(181, 'K06.18', 'Sưng nướu đặc hiệu khác', 'Other specified gingival enlargement', 13),
            array(182, 'K06.2', 'Sang thương nướu và sóng hàm liên quan đến chấn thương', 'Gingival and edentulous alveolar ridge lesions associated with trauma', 13),
            array(183, 'K06.20', 'Do chấn thương khớp cắn', 'Due to traumatic occlusion', 13),
            array(184, 'K06.21', 'Do chải răng', 'Due to toothbrushing ', 13),
            array(185, 'K06.22', 'Sừng hóa chức năng', 'Frictional [funtional] keratosis', 13),
            array(186, 'K06.23', 'Tăng sinh do kích thích [tăng sinh do hàm giả]', 'Irritative hyperplasia [denture hyperplasia]', 13),
            array(187, 'K06.28', 'Sang thương nướu và sóng hàm đặc hiệu khác liên quan đến chấn thương', 'Other specified gingival and edentulous alveolar ridge lesions associated with trauma', 13),
            array(188, 'K06.8', 'Rối loạn xác định khác của nướu và sóng hàm', 'Other specified disorders of gingiva and edentulous alveolar ridge', 13),
            array(189, 'K06.80', 'Nang nướu ở người trưởng thành', 'Gingival cyst of adult', 13),
            array(190, 'K06.81', 'U hạt tế bào khổng lồ ngoại biên [u nướu tế bào khổng lồ]', 'Peripheral giant cell granuloma [giant cell epulis]', 13),
            array(191, 'K06.82', 'U sợi nướu', 'Fibrous epulis', 13),
            array(192, 'K06.83', 'U hạt sinh mủ', 'Pyogenic granuloma', 13),
            array(193, '', 'Ngoại trừ: u hạt sinh mủ không ở nướu hay sóng hàm ', 'Excludes: pyogenic granuloma of site other than gingiva or edentulous alveolar ridge (K13.40)', 13),
            array(194, 'K06.84', 'Sóng hàm phập phều', 'Flabby ridge', 13),
            array(195, 'K06.88', 'Rối loạn khác', 'Other ', 13),
            array(196, 'K07', 'Dị dạng răng-mặt [bao gồm lệch lạc khớp cắn]', 'Dentofacial anomalies [including malocclusion]', 14),
            array(197, 'K07.0', 'Bất thường chính về kích thước xương hàm', 'Major anomalies of jaw size', 14),
            array(198, '', 'Ngoại trừ: Bệnh to cực (E22.0)', 'Excludes: acromegaly (E2.0)', 14),
            array(199, '', 'Teo nửa mặt hay phì đại nửa mặt (Q07.4)', 'hemifacial atrophy or hypertrophy (Q67.4)', 14),
            array(200, '', 'Hội chứng Robin (Q87.0)', 'Robin\'s syndrome (Q87.0)', 14),
            array(201, 'K07.00', 'Tật to hàm trên [quá sản hàm trên]', 'Maxillary macrognathism [maxillary hyperplasia]', 14),
            array(202, 'K07.01', 'Tật to hàm dưới [quá sản hàm dưới]', 'Mandibular macrognathism [mandibular hyperplasia]', 14),
            array(203, 'K07.02', 'Tật to cả hai hàm trên, dưới', 'Macrognathism, both jaws', 14),
            array(204, 'K07.03', 'Tật nhỏ hàm trên [thiểu sản hàm trên]', 'Maxillary micrognathism [mandibular hypoplasia]', 14),
            array(205, 'K07.04', 'Tật nhỏ hàm dưới [thiểu sản hàm dưới]', 'Mandibular micrognathism [mandibular hypoplasia]', 14),
            array(206, 'K07.05', 'Tật nhỏ hai hàm', 'Micrognathism, both jaws', 14),
            array(207, 'K07.08', 'Dị dạng về kích thước xương hàm đặc hiệu khác', 'Other specified jaw size anomalies', 14),
            array(208, 'K07.1', 'Bất thường tương quan nền sọ xương hàm', 'Anomalies of jaw-cranial base relationship', 14),
            array(209, 'K07.10', 'Mất cân xứng', 'Asymmetries', 14),
            array(210, '', 'Ngoại trừ: Teo nửa mặt (Q64.40)', 'Excludes: hemifacial atrophy (Q64.40)', 14),
            array(211, '', 'Phì đại nửa mặt (Q67.41)', 'hemifacial hypertrophy (Q67.41)', 14),
            array(212, 'K07.11', 'Vẩu (hô) hàm dưới', 'Mandibular prognathism', 14),
            array(213, 'K07.12', 'Vẩu (hô) hàm trên', 'Maxillary prognathism', 14),
            array(214, 'K07.13', 'Lùi hàm dưới', 'Mandibular retrognathism', 14),
            array(215, 'K07.14', 'Lùi hàm trên', 'Maxillary retrognathism', 14),
            array(216, 'K07.18', 'Bất thường đặc hiệu khác về tương quan hàm - nền sọ', 'Other specified anomalies of jaw-cranial base relationship', 14),
            array(217, 'K07.2', 'Bất thường của tương quan cung răng', 'Anomalies of dental arch relationship', 14),
            array(218, 'K07.20', 'Khớp cắn lệch xa', 'Disto-occlusion', 14),
            array(219, 'K07.21', 'Khớp cắn lệch gần', 'Mesio-occlusion', 14),
            array(220, 'K07.22', 'Cắn chìa quá mức [độ cắn phủ theo chiều ngang]', 'Excessive overjet [horizontal overbite]', 14),
            array(221, 'K07.23', 'Cắn phủ quá mức [độ cắn phủ theo chiều đứng]', 'Excessive overbite vertical overbite]', 14),
            array(222, 'K07.24', 'Cắn hở', 'Openbite', 14),
            array(223, 'K07.25', 'Cắn chéo (răng cửa, răng cối)', 'Crossbite (anterior, posterior)', 14),
            array(224, 'K07.26', 'Lệch đường giữa', 'Midline deviation', 14),
            array(225, 'K07.27', 'Khớp cắn lệch trong vùng răng sau hàm dưới', 'Posterior lingual occlusion of mandibular teeth', 14),
            array(226, 'K07.28', 'Bất thường đặc hiệu khác về tương quan cung răng', 'Other specified anomalies of dental arch relationship', 14),
            array(227, 'K07.3', 'Bất thường vị trí răng ', 'Anomalies of tooth position', 14),
            array(228, 'K07.30', 'Răng chen chúc', 'Crowding', 14),
            array(229, 'K07.31', 'Răng sai vị trí', 'Displacement', 14),
            array(230, 'K07.32', 'Răng xoay', 'Rotation', 14),
            array(231, 'K07.33', 'Hở răng, hở kẽ', 'Spacing, Diastema ', 14),
            array(232, 'K07.34', 'Răng chuyển vị', 'Transposition', 14),
            array(233, 'K07.35', 'Răng ngầm hay răng mọc kẹt ở vị trí bất thường', 'Embedded or impacted teeth in abnormal position', 14),
            array(234, 'K07.38', 'Bất thường vị trí răng đặc hiệu khác', 'Other specified anomalies of tooth position', 14),
            array(235, 'K07.4', 'Lệch lạc khớp cắn, không xác định', 'Malocclusion, unspecified', 14),
            array(236, 'K07.5', 'Bất thường chức năng răng mặt', 'Dentofacial functional abnormalities', 14),
            array(237, '', 'Ngoại trừ: nghiến răng [nghiền răng] (F45.82)', 'Excludes: bruxism [teeth grinding] (F45.82)', 14),
            array(238, 'K07.50', 'Đóng hàm bất thường', 'Abnormal jaw closure', 14),
            array(239, 'K07.51', 'Lệch lạc khớp cắn do nuốt bất thường', 'Malocclusion due to abnormal swallowing ', 14),
            array(240, 'K07.54', 'Lệch lạc khớp cắn do thở miệng', 'Malocclusion due to mouth breathing ', 14),
            array(241, 'K07.55', 'Lệch lạc khớp cắn do thói quen lưỡi, môi, ngón tay', 'Malocclusion due to tongue, lip or finger habits ', 14),
            array(242, 'K07.58', 'Bất thường chức năng răng mặt đặc hiệu khác', 'Other specified dentofacial functional abnormalities', 14),
            array(243, 'K07.6', 'Rối loạn khớp thái dương', 'Temporomandibular joint disorders', 14),
            array(244, 'K07.60', 'Hội chứng đau loạn năng khớp thái-dương hàm [Costen]', 'Temporomandibular joint pain-dysfunction syndrome [Costen]', 14),
            array(245, '', 'Ngoại trừ: trật khớp thái dương hàm (S03.0) và giãn dây chằng khớp (S03.4) do chấn thương được liệt kê ở chương 13', 'Excludes: current temporomandibular joint dislocation (S03.0) and strain (S03.4) disease listed in chapter XIII', 14),
            array(246, 'K07.61', 'Hàm nhảy nấc', 'Clicking (snapping) jaws', 14),
            array(247, 'K07.62', 'Trật khớp tái phát và bán trật khớp thái dương hàm ', 'Recurrent dislocation and subluxation of temporomandibular joint', 14),
            array(248, 'K07.63', 'Đau khớp thái dương hàm, không phân loại nơi khác', 'Pain in temporomandibular joit, not elsewhere classified', 14),
            array(249, 'K07.64', 'hạn chế vận động khớp thái dương hàm, không phân loại nơi khác', 'Stiffness in temporomandibular joint, not elsewhere classified', 14),
            array(250, 'K07.65', 'Gai xương khớp thái dương hàm', 'Osteophyte of temporomandibular joint', 14),
            array(251, 'K07.68', 'Rối loạn khớp thái dương hàm đặc hiệu khác', 'Other specified temporomandibular joint disorders', 14),
            array(252, 'K07.8', 'Các bất thường răng mặt khác', 'Other dentofacial anomalies', 14),
            array(253, 'K08', 'Bệnh khác của răng và cấu trúc nâng đỡ', 'Other disorders of teeth and supporting structures', 14),
            array(254, 'K08.0', 'Rụng răng do nguyên nhân hệ thống', 'Exfoliation of teeth due to systemic causes', 14),
            array(255, 'K08.1', 'Mất răng do tai nạn, do nhổ răng hay bệnh nha chu khu trú', 'Loss of teeth due to accident, extraction or local periodontal disease', 14),
            array(256, 'K08.2', 'Teo sóng hàm ', 'Atrophy of edentulous alveolar ridge', 14),
            array(257, 'K08.3', 'Chân răng còn sót', 'Retained dental root', 14),
            array(258, 'K08.80', 'Đau răng KXĐ', 'Toothache NOS', 14),
            array(259, 'K08.81', 'Xương ổ răng bất thường', 'Irregular alveolar process', 14),
            array(260, 'K08.82', 'Phì đại sóng hàm KXĐ', 'Enlargement of alveolar ridge NOS', 14),
            array(261, 'K09', 'Nang vùng miệng, không phân loại nơi khác', 'Cysts of oral region, not elsewhere classified', 15),
            array(262, 'K09.0', 'Nang (do răng) phát triển', 'Developmental odontogenic cysts', 15),
            array(263, 'K09.00', 'Nang mọc răng', 'Eruption', 15),
            array(264, 'K09.01', 'Nang nướu', 'Gingival ', 15),
            array(265, 'K09.02', 'Nang sừng [nang nguyên thủy]', 'Keratocyst [primodial]', 15),
            array(266, 'K09.03', 'Nang thân răng ', 'Follicular [dentigerous]', 15),
            array(267, 'K09.04', 'Nang bên nha chu ', 'Lateral periodontal ', 15),
            array(268, 'K09.08', 'Nang (do răng) phát triển khác', 'Other specified developmental odontogenic cysts', 15),
            array(269, 'K09.1', 'Nang (không do răng) phát triển vùng miệng', 'Developmental (nonodontogenic) cysts of oral region', 15),
            array(270, '', 'Bao gồm: Nang khe', 'Includes: \"fissural\" cysts', 15),
            array(271, 'K09.10', 'Nang gò cầu hàm ', 'Globulomaxillary', 15),
            array(272, 'K09.11', 'Nang giữa khẩu cái ', 'Median palatal ', 15),
            array(273, 'K09.12', 'Nang mũi khẩu [nang ống răng cửa]', 'Nasopalatine [incisive canal]', 15),
            array(274, 'K09.13', 'Nang nhú khẩu cái', 'Palatine papilla', 15),
            array(275, 'K09.18', 'Nang phát triển đặc hiệu khác ở vùng miệng', 'Other specified developmental cysts of oral region', 15),
            array(276, 'K09.2', 'Nang khác của xương hàm', 'Other cysts of jaw', 15),
            array(277, 'K09.20', 'Nang phình mạch', 'Aneurysmal bone cyst', 15),
            array(278, 'K09.21', 'Nang xương đơn độc [nang chấn thương] [nang xuất huyết]', 'Solitary bone [traumatic] [haemorrhagic] cyst', 15),
            array(279, 'K09.22', 'Nang thượng bì xương hàm không thể xác định do răng hay không do răng', 'Epithelial jaw cysts not identifiable as odontogenic or nonodontogenic', 15),
            array(280, 'K09.28', 'Nang khác của xương hàm', 'Other specified cysts of jaw', 15),
            array(281, 'K09.8', 'Nang khác ở vùng miệng, không phân loại nơi khác', 'Other cysts of oral region, not elsewhere classified', 15),
            array(282, 'K09.80', 'Nang dạng bì', 'Dermoid cyst', 15),
            array(283, 'K09.81', 'Nang dạng thượng bì', 'Epiermoid cyst', 15),
            array(284, 'K09.82', 'Nang nướu sơ sinh', 'Gingival cyst of newborn', 15),
            array(285, 'K09.83', 'Nang khẩu cái sơ sinh', 'Palatal cyst of newborn', 15),
            array(286, '', 'Hạt Epstein', 'Epstein\'s pearl', 15),
            array(287, 'K09.84', 'Nang mũi - xương ổ [nang mũi-môi]', 'Nasoalveolar [nasolabial] cyst', 15),
            array(288, 'K09.85', 'Nang lympho biểu mô ', 'Lymphoepithelial cyst', 15),
            array(289, 'K09.88', 'Nang đặc hiệu khác ở vùng miệng', 'Other specified cysts of oral region', 15),
            array(290, 'K10', 'Bệnh khác của xương hàm', 'Other diseases of jaws', 16),
            array(291, 'K10.0', 'Rối loạn phát triển của xương hàm', 'Developmental disorders of jaws', 16),
            array(292, 'K10.00', 'Lồi rắn hàm dưới', 'Torus mandibularis', 16),
            array(293, 'K10.01', 'Lồi rắn khẩu cái', 'Torus palatinus', 16),
            array(294, 'K10.02', 'Nang xương tiềm ẩn', 'Latent bone cyst ', 16),
            array(295, '', 'Nang Stafne', 'Stafne\'s cyst ', 16),
            array(296, 'K10.08', 'Rối loạn phát triển đặc hiệu khác của xương hàm', 'Other specified developmental disorders of jaws', 16),
            array(297, 'K10.1', 'U hạt tế bào khổng lồ, trung tâm', 'Giant cell granuloma, central', 16),
            array(298, '', 'U hạt tế bào khổng lồ KXĐ', 'Giant cell granuloma NOS', 16),
            array(299, 'K10.2', 'Tình trạng viêm của xương hàm', 'Inflammatory conditions of jaws', 16),
            array(300, 'K10.20', 'Viêm xương hàm', 'Osteitis of jaw', 16),
            array(301, 'K10.21', 'Viêm cốt tủy xương hàm', 'Osteomyelitis of jaw', 16),
            array(302, 'K10.22', 'Viêm màng xương xương hàm', 'Periosteitis of jaw', 16),
            array(303, 'K10.23', 'Viêm màng xương xương hàm mạn tính ', 'Chronic periosteitis of jaw', 16),
            array(304, '', 'Bệnh mao mạch thể kính ', 'Hyaline microangiopathy', 16),
            array(305, '', 'U hạt nhịp mạch ', 'Pulse granuloma', 16),
            array(306, 'K10.24', 'Viêm cốt tuỷ xương hàm trên ở trẻ sơ sinh', 'Neonatal osteomyelitis of maxilla [neonatal maxillitis] ', 16),
            array(307, 'K10.25', 'Xương chết', 'Sequestrum', 16),
            array(308, 'K10.26', 'Hoại tử xương do tia xạ', 'Osteoradionecrosis', 16),
            array(309, 'K10.28', 'Viêm xương hàm đặc hiệu khác', 'Other specified inflammatory conditions of jaws', 16),
            array(310, 'K10.3', 'Viêm xương ổ răng ', 'Alveolitis of jaws', 16),
            array(311, '', 'Viêm ổ răng khô', 'Dry socket', 16),
            array(312, 'K10.8', 'Bệnh xác định khác của xương hàm', 'Other specified diseases of jaws', 16),
            array(313, '', 'Loạn sản sợi, loạn sản sụn (Q78.1)', 'fibrous dysplasia, polyostotic (Q78.1)', 16),
            array(314, 'K10.80', 'Loạn sản sợi xương hàm', 'Cherubism', 16),
            array(315, 'K10.81', 'Quá sản lồi cầu một bên xương hàm dưới', 'Unilateral condylar hyperplasia of mandible', 16),
            array(316, 'K10.82', 'Thiểu sản lồi cầu một  bên xương hàm dưới', 'Unilateral condylar hypoplasia of mandible', 16),
            array(317, 'K10.83', 'Loạn sản sợi xương hàm', 'Fibrous dysplasia of jaw ', 16),
            array(318, 'K10.88', 'Bệnh đặc hiệu khác xương hàm', 'Other specified diseases of jaws', 16),
            array(319, '', 'Lồi xương xương hàm', 'Exostosis of jaw', 16),
            array(320, 'K11', 'Bệnh tuyến nước bọt', 'Diseases of salivary glands', 17),
            array(321, 'K11.0', 'Teo tuyến nước bọt', 'Atrophy of salivary gland', 17),
            array(322, 'K11.1', 'Phì đại tuyến nước bọt', 'Hypertrophy of salivary gland', 17),
            array(323, 'K11.2', 'Viêm tuyến nước bọt', 'Sialoadenitis', 17),
            array(324, '', 'Quai bị (B26.-)', 'Epidemic parotitis [mumps] (B26._)', 17),
            array(325, '', 'Viêm màng mạch nho tuyến mang tai (D86.8)', 'uveoparotitis [Heerfordt] (D86.8)', 17),
            array(326, 'K11.3', 'Áp xe tuyến nước bọt', 'Abscess of salivary gland', 17),
            array(327, 'K11.4', 'Dò tuyến nước bọt', 'Fistula of salivary gland', 17),
            array(328, '', 'Dò tuyến nước bọt bẩm sinh (Q38.43)', 'congenital fistula of salivary gland (Q38.43)', 17),
            array(329, 'K11.5', 'Sỏi (sạn) tuyến nước bọt', 'Sialolithiasis', 17),
            array(330, '', 'Vôi [đá] trong ống tuyến ', 'Calculus [stone] in salivary duct', 17),
            array(331, 'K11.6', 'Nang nhầy tuyến nước bọt', 'Mucocele of salivary gland', 17),
            array(332, '', 'Nang nhái', 'Ranula', 17),
            array(333, 'K11.60', 'Nang nghẽn niêm dịch', 'Mucous retention cyst ', 17),
            array(334, 'K11.61', 'Nang thoát mạch niêm dịch', 'Mucous extravasation cyst ', 17),
            array(335, 'K11.7', 'Rối loạn chế tiết nước bọt', 'Disturbances of salivary secretion', 17),
            array(336, 'K11.70', 'Giảm tiết nước bọt', 'Hyposecretion', 17),
            array(337, 'K11.71', 'Chứng khô miệng', 'Xerostomia', 17),
            array(338, 'K11.72', 'Tăng tiết nước bọt', 'Hypersecretion [ptyalism]', 17),
            array(339, 'K11.78', 'Rối loạn chế tiết nước bọt đặc hiệu khác ', 'Other specified disturbances of salivary secretion', 17),
            array(340, 'K11.8', 'Bệnh khác của tuyến nước bọt', 'Other diseases of salivary glands', 17),
            array(341, '', 'Hội chứng khô miệng [Sjogren] (M35.0)', 'sicca syndrome [Sjogren] (M35.0)', 17),
            array(342, 'K11.80', 'Sang thương lympho biểu mô lành tính tuyến nước bọt ', 'Benign lymphoepithelial lesion of salivary gland', 17),
            array(343, 'K11.81', 'Bệnh Mikulicz', 'Mikulicz\' disease', 17),
            array(344, 'K11.82', 'Chứng hẹp ống dẫn tuyến', 'Stenosis [stricture] of salivary duct', 17),
            array(345, 'K11.83', 'Chứng giãn ống dẫn tuyến', 'Sialectasia', 17),
            array(346, 'K11.84', 'Chứng ứa nước bọt', 'Sialosis', 17),
            array(347, 'K11.85', 'Dị sản tuyến nước bọt hoại tử', 'Necrotizing sialometaplasia', 17),
            array(348, 'K11.88', 'Bệnh đặc hiệu khác của tuyến nước bọt', 'Other specified diseases of salivary glands', 17),
            array(349, 'K12', 'Viêm miệng và sang thương liên quan', 'Stomatitis and related lesions', 18),
            array(350, '', 'Tăng sản biểu mô dạng điểm (B07.X2)', 'focal epithelial hyperplasia (B07.X2)', 18),
            array(351, '', 'Viêm miệng mụn nước (B08.5X)', 'herpagina (B08.5X)', 18),
            array(352, '', 'Viêm miệng mủ sùi (L08.0X)', 'pyostomatitis vegetant (L08.0X) ', 18),
            array(353, '', 'Viêm miệng hoại tử cấp (A69.0)', '. acute necrotizing (A69.0)', 18),
            array(354, '', 'Viêm miệng dị ứng (L23.-)', '. allergic (L23._)', 18),
            array(355, '', 'Viêm miệng do nấm Candida (B17.0)', '. candidal (B37.0)', 18),
            array(356, '', 'Viêm miệng do virus Coxsackie KXĐ (B34.1)', '. Coxsakievirus NOS (B34.1)', 18),
            array(357, '', 'Viêm miệng do bệnh dịch súc vật (B08.8)', '. epizootic (B08.8)', 18),
            array(358, '', 'Viêm miệng do thoi-xoắn khuẩn (A69.0)', '. fusospirochaetal (A69.0)', 18),
            array(359, '', 'Viêm miệng do thuốc (T36 - T50)', '. medicamentosa (T36 - T50)', 18),
            array(360, '', 'Viêm miệng do nấm (B37.0)', '. mycotic (B37.0)', 18),
            array(361, '', 'Viêm miệng mụn nước với phát ban (B08.4)', '. vesicular with exanthem (B08.4)', 18),
            array(362, '', 'Viêm miệng-nướu do liên cầu khuẩn (K05.00)', 'streptococcal gingivostomatitis (K05.00)', 18),
            array(363, '', 'Bệnh viêm miệng có mụn nước do siêu vi [sốt Indiana] (A93.8X)', 'vesicular stomatitis virus disease [Indiana fever] (A93.8X)', 18),
            array(364, 'K12.0', 'Áp tơ tái phát ', 'Recurrent oral aphthae', 18),
            array(365, 'K12.00', 'Áp tơ nhỏ tái phát (Viêm miệng áp tơ, Áp tơ Mikulicz)', 'Recurrent (minor) aphthae (Aphthous stomatitis, Mikulicz\' aphthae)', 18),
            array(366, 'K12.01', 'Viêm quanh hạch hoại tử niêm mạc tái phát', 'Periadenitis mucosa necrotica recurrens', 18),
            array(367, '', 'Viêm miệng Aptơ sẹo (áp tơ khổng lồ, áp tơ Sutton)', 'Cicatrizing aphthous stomatitis (Major aphthae, Sutton\'s aphthae)', 18),
            array(368, 'K12.02', 'Viêm miệng dạng mụn rộp ', 'Stomatitis herpestiformis [herpestiform eruption]', 18),
            array(369, '', 'Viêm da dạng mụn rộp (L13.0X)', 'Dermatitis herpestiformis (L13.0X)', 18),
            array(370, '', 'Viêm miệng nướu do vi rút herpes', 'herpesviral gingivostomatitis (B00.2X)', 18),
            array(371, 'K12.03', 'Áp tơ Bednar', 'Bednar\'s aphthae', 18),
            array(372, 'K12.04', 'Loét sang chấn ', 'Traumatic ulcer', 18),
            array(373, 'K12.08', 'Áp tơ miệng tái phát đặc hiệu khác', 'Other specified recurrent oral aphthae', 18),
            array(374, 'K12.1', 'Dạng khác của viêm miệng', 'Other forms of stomatitis', 18),
            array(375, 'K12.10', 'Viêm miệng giả', 'Stomatitis artifacta', 18),
            array(376, 'K12.11', 'Viêm miệng bản đồ', 'Geographic stomatitis ', 18),
            array(377, 'K12.12', 'Viêm miệng hàm giả', 'Denture stomatitis', 18),
            array(378, '', 'Viêm miệng hàm giả do nấm Candida (B37.03)', 'Denture stomatitis due to candidal infection (B37.03)', 18),
            array(379, 'K12.13', 'Tăng sinh dạng nhú khẩu cái', 'Papillary hyperplasia of palate', 18),
            array(380, 'K12.14', 'Viêm miệng tiếp xúc', 'Contact stomatitis', 18),
            array(381, '', 'Viêm miệng cuộn gòn', 'Cotton roll stomatitis', 18),
            array(382, 'K12.18', 'Các dạng viêm miệng đặc hiệu khác', 'Other specified forms of stomatitis', 18),
            array(383, 'K12.2', 'Viêm mô tế bào và áp xe vùng miệng', 'Cellulitis and abscess of mouth', 18),
            array(384, '', 'Viêm tấy ', 'Phlegmon', 18),
            array(385, '', 'Áp xe dưới hàm', 'Submandibular abscess', 18),
            array(386, 'K13', 'Bệnh khác của môi và niêm mạc miệng', 'Other diseases of lip and oral mucosa', 19),
            array(387, '', 'Bao gồm: Rối loạn biểu mô lưỡi', 'Includes: epithelial disturbances of tongue', 19),
            array(388, 'K13.0', 'Bệnh của môi', 'Diseases of lips', 19),
            array(389, '', 'Viêm môi do ánh sáng (L56.8X)', 'Actinic cheilitis (L56.8X)', 19),
            array(390, '', 'Bệnh thiếu Riboflavin (E53.0)', 'Ariboflavinosis (E53.0)', 19),
            array(391, 'K13.00', 'Chốc mép', 'Angular cheilitis', 19),
            array(392, '', 'Chốc mép do:', 'Perlèche due to: ', 19),
            array(393, '', '. Nấm Candida (B37.0)', '. candidiasis (B37.0)', 19),
            array(394, '', '. Thiếu Riboflavin (E53.0)', '. riboflavin deficiency (E53.0)', 19),
            array(395, 'K13.01', 'Viêm môi áp xe tuyến ', 'Cheilitis glandularis apostematosa', 19),
            array(396, 'K13.02', 'Viêm môi tróc', 'Cheilitis, exfoliative', 19),
            array(397, 'K13.03', 'Viêm môi KXĐ', 'Cheilitis NOS', 19),
            array(398, 'K13.04', 'Đau môi ', 'Cheilodynia', 19),
            array(399, 'K13.08', 'Bệnh đặc hiệu khác của môi', 'Other specified diseases of lips', 19),
            array(400, 'K13.1', 'Cắn má và môi', 'Cheek and lip biting', 19),
            array(401, 'K13.2', 'Bạch sản và rối loạn khác của biểu mô miệng, bao gồm lưỡi', 'Leukoplakia and other disturbances of oral epithelium, including tongue', 19),
            array(402, '', 'Bạch sản do nấm Candida (B37.02)', 'candidal leukoplakia (B37.02)', 19),
            array(403, '', 'Tăng sinh niêm mạc dạng điểm (B07.X2)', 'focal epithelial hyperplasia (B07.X2)', 19),
            array(404, 'K13.20', 'Bạch sản tự phát', 'Leukoplakia, idiopathic', 19),
            array(405, 'K13.21', 'Bạch sản do thuốc lá', 'Leukoplakia, tobaco-associated', 19),
            array(406, 'K13.22', 'Hồng sản', 'Erythoplakia', 19),
            array(407, 'K13.23', 'Bạch phù', 'Leukooedema', 19),
            array(408, 'K13.24', 'Khẩu cái người hút thuốc [sừng hóa khẩu cái do Nicotin] [Viêm miệng Nicotin]', 'Smoker\'s palate [leukokeratosis nicotina palati] [nicotinic stomatitis]', 19),
            array(409, 'K13.28', 'Khác', 'Other', 19),
            array(410, '', 'Bạch sản KXĐ', 'Leukoplakia NOS', 19),
            array(411, 'K13.3', 'Bạch sản tóc', 'Hairy leukoplakia', 19),
            array(412, 'K13.4', 'U hạt và sang thương dạng u hạt của niêm mạc miệng', 'Granuloma and granuloma-like lesions of oral mucosa', 19),
            array(413, 'K13.40', 'U hạt sinh mủ', 'Pyogenic granuloma', 19),
            array(414, 'K13.41', 'U hạt ưa acid của niêm mạc miệng', 'Eosinophilic granuloma  of oral mucosa', 19),
            array(415, '', 'U hạt ưa acid của xương (D76.00)', 'Eosinophilic granuloma  of bone (D76.00)', 19),
            array(416, '', 'Chứng mô bào huyết X (D76.-)', 'histiocytosis X (D76._)', 19),
            array(417, 'K13.42', 'U vàng mụn cóc [chứng mô bào huyết Y]', 'Verrucous xanthoma [histiocytosis Y]', 19),
            array(418, 'K13.48', 'U hạt và các sang thương giống u hạt đặc hiệu khác ở niêm mạc miệng', 'other specified granuloma and granuloma-like lesions of oral mucosa', 19),
            array(419, 'K13.5', 'Xơ hóa dưới niêm mạc miệng', 'Oral submucous fibrosis', 19),
            array(420, 'K13.6', 'Tăng sinh do kích thích của niêm mạc miệng', 'Irritative hyperplasia of oral mucosa', 19),
            array(421, '', 'Ngoại trừ: Tăng sinh do kích thích [tăng sinh do hàm giả] sóng hàm (K06.23)', 'Excludes: irritative hyperplasia [denture hyperplasia] of edentulous alveolar ridge (K06.23)', 19),
            array(422, 'K13.7', 'Sang thương khác và không xác định của niêm mạc miệng', 'Other and unspecified lesions of oral mucosa', 19),
            array(423, 'K13.70', 'Nhiễm melanin quá mức ', 'Excessive melanin pigmentation', 19),
            array(424, '', 'Hắc sản (chứng nhiễm melanin niêm mạc miệng)', 'Melanoplakia', 19),
            array(425, '', 'Chứng nhiễm melanin ở người hút thuốc', 'Smoker\'s melanosis', 19),
            array(426, 'K13.71', 'Lỗ dò ở miệng', 'Oral fistula', 19),
            array(427, '', 'Dò miệng-xoang hàm (T81.8)', 'Oroantral fistula (T81.8)', 19),
            array(428, 'K13.72', 'Xăm chủ ý', 'Delibarate tattoo ', 19),
            array(429, '', 'Nhiễm sắc Amalgam (T81.50)', 'amalgam tattoo (T81.50)', 19),
            array(430, 'K13.73', 'Bệnh tích tụ chất nhầy dạng điểm', 'Focal oral mucinosis', 19),
            array(431, 'K13.78', 'Sang thương đặc hiệu khác của niêm mạc miệng', 'Other specified lesions of oral mucosa', 19),
            array(432, '', 'Đường nhai ', 'Linea alba', 19),
            array(433, 'K13.79', 'Sang thương niêm mạc miệng, không xác định ', 'Lesion of oral mucosa, unspecified', 19),
            array(434, 'K14', 'Bệnh của lưỡi', 'Diseases of tongue', 20),
            array(435, '', 'Tăng sinh biểu mô dạng điểm (B07.X2)', 'focal epithelial hyperplasia (B07.X2)', 20),
            array(436, '', 'Lưỡi lớn (bẩm sinh) (Q38.2X)', 'macroglossia (congenital) (Q38.2X)', 20),
            array(437, 'K14.0', 'Viêm lưỡi', 'Glossitis', 20),
            array(438, 'K14.00', 'Áp xe lưỡi', 'Abscess of tongue', 20),
            array(439, 'K14.01', 'Loét lưỡi do sang chấn ', 'Traumatic ulceration of tongue', 20),
            array(440, 'K14.08', 'Viêm lưỡi đặc hiệu khác', 'Other specified glossitis', 20),
            array(441, 'K14.09', 'Viêm lưỡi, không xác định ', 'Glossitis, unspecified', 20),
            array(442, '', 'Loét lưỡi KXĐ', 'Ulcer of tongue NOS', 20),
            array(443, 'K14.1', 'Lưỡi bản đồ ', 'Geographic tongue', 20),
            array(444, '', 'Viêm lưỡi di cư lành tính', 'Benign migratory glossitis', 20),
            array(445, '', 'Viêm lưỡi tróc vảy từng mảng ', 'Glossitis areata axfoliativa', 20),
            array(446, 'K14.2', 'Viêm lưỡi giữa hình thoi', 'Median rhomboid glossitis', 20),
            array(447, 'K14.3', 'Phì đại nhú lưỡi', 'Hypertrophy of tongue papillae', 20),
            array(448, 'K14.30', 'Lưỡi có màng bọc ', 'Coated tongue', 20),
            array(449, 'K14.31', 'Lưỡi lông', 'Hairy tongue', 20),
            array(450, '', 'Lưỡi lông đen', 'Black hairy tongue', 20),
            array(451, '', 'Lưỡi lông nhung xám', 'Lingua villosa nigra', 20),
            array(452, 'K14.32', 'Phì đại nhú lá ', 'Hypertrophy of foliate papillae', 20),
            array(453, 'K14.38', 'Phì đại nhú lưỡi đặc hiệu khác', 'Other specified hypertrophy of tongue papillae', 20),
            array(454, '', 'Lưỡi có lông do kháng sinh', 'hairy tongue due to antibiotics', 20),
            array(455, 'K14.39', 'Phì đại nhú lưỡi, không xác định ', 'Hypertrophy of tongue papillae, unspecified ', 20),
            array(456, 'K14.4', 'Teo nhú lưỡi', 'Atrophy of tongue papillae', 20),
            array(457, 'K14.5', 'Lưỡi gấp nếp (nứt nẻ, có rãnh)', 'Plicated (fissured, furrowed) tongue', 20),
            array(458, '', 'Lưỡi nứt nẻ (bẩm sinh) (Q38.33)', 'Fissured tongue, congenital (Q38.33)', 20),
            array(459, 'K14.6', 'Chứng đau lưỡi', 'Glossodynia', 20),
            array(460, '', 'Bất thường cảm giác vị giác (R43.-)', 'Abnormalities of taste (R43._)', 20),
            array(461, 'K14.60', 'Chứng rát bỏng ở lưỡi', 'Glossopyrosis (burning tongue]', 20),
            array(462, 'K14.61', 'Đau lưỡi', 'Glossodynia (painful tongue]', 20),
            array(463, 'K14.68', 'Đau lưỡi đặc hiệu khác', 'Other specified glossodynia', 20),
            array(464, 'K14.8', 'Bệnh khác của lưỡi', 'Other diseases of tongue', 20),
            array(465, 'K14.80', 'Lưỡi có khía', 'Crenated tongue [ligua indentata]', 20),
            array(466, 'K14.81', 'Lưỡi phì đại', 'Hypertrophy of tongue', 20),
            array(467, '', 'Phì đại nửa lưỡi', 'Hemihypertrophy of tongue', 20),
            array(468, '', 'Lưỡi lớn (bẩm sinh) (Q38.2X)', 'Macroglossia (congenital (Q38.2X))', 20),
            array(469, 'K14.82', 'Teo lưỡi', 'Atrophy of tongue', 20),
            array(470, '', 'Teo nửa lưỡi', 'Hemiatrophy of tongue', 20),
            array(471, 'k14.88', 'Bệnh đặc hiệu khác ở lưỡi', 'Other specified diseases of tongue', 20),
            array(472, '', 'Bệnh hạnh nhân lưỡi', 'Diseases of lingual tonsil', 20),
            array(473, '', 'Các u ác tính ở môi, khoang miệng và hầu họng', 'Malignant neoplasms of lip, oral cavity and pharynx', 20),
            array(474, 'C00', 'U ác của môi', 'Malignant neoplasm of lip', 21),
            array(475, 'C00.0', 'Phần ngoài môi trên', 'External upper lip', 21),
            array(476, 'C00.0X', 'Viền môi trên (Vùng để son môi)', 'Vermilion border (lipstick area) of upper lip', 21),
            array(477, 'C00.1', 'Phần ngoài môi dưới', 'External lower lip', 21),
            array(478, 'C00.1X', 'Viền môi dưới (Vùng để son môi)', 'Vermilion border (lipstick area) of lower lip', 21),
            array(479, 'C00.2', 'Phần ngoài môi, không xác định', 'External lip, unspecified', 21),
            array(480, 'C00.2X', 'Viền môi (Vùng để son môi) KXĐ', 'Vermilion border (lipstick area) NOS', 21),
            array(481, 'C00.3', 'Môi trên, mặt trong', 'Upper lip, inner aspect', 21),
            array(482, '', 'Bao gồm: thắng môi', 'Includes: frenum', 21),
            array(483, 'C00.3X', 'Niêm mạc môi', 'Labial mucosa', 21),
            array(484, 'C00.4', 'Môi dưới, mặt trong', 'Lower lip, inner aspect', 21),
            array(485, '', 'Bao gồm: Thắng môi', 'Includes: frenum', 21),
            array(486, 'C00.4X', 'Niêm mạc môi', 'Labial mucosa', 21),
            array(487, 'C00.5', 'Môi, mặt trong, không xác định', 'Lip, unspecified, inner aspect', 21),
            array(488, 'C00.5X', 'Niêm mạc môi, không xác định môi trên hay dưới', 'Labial mucosa, not specified whether upper or lower', 21),
            array(489, 'C00.6', 'Mép môi', 'Commissure of lip', 21),
            array(490, 'C01', 'U ác của đáy lưỡi', 'Malignant neoplasm of base of tongue', 22),
            array(491, '', 'Mặt lưng đáy lưỡi', 'Dorsal surface of base of tongue', 22),
            array(492, '', 'Phần ba sau của lưỡi', 'Posterior third of tongue', 22),
            array(493, 'C02', 'U ác của phần khác và không xác định của lưỡi', 'Malignant neoplasm of other and unspecified parts of tongue', 23),
            array(494, 'C02.0', 'Mặt lưng lưỡi', 'Dorsal surface of tongue', 23),
            array(495, 'C02.0X', 'Hai phần ba trước lưỡi, mặt lưng', 'Anterior two-thirds of tongue, dorsal surface', 23),
            array(496, 'C02.1', 'Bờ lưỡi', 'Border of tongue', 23),
            array(497, 'C02.10', 'Đầu lưỡi', 'Tip of tongue', 23),
            array(498, 'C02.11', 'Hông lưỡi', 'Lateral border of tongue', 23),
            array(499, 'C02.2', 'Mặt bụng lưỡi', 'Ventral surface of tongue', 23),
            array(500, 'C02.0X', 'Hai phần ba trước của lưỡi, mặt bụng ', 'Anterior two-thirds of tongue, ventral surface', 23),
            array(501, '', 'Thắng lưỡi', 'Lingual frenum', 23),
            array(502, 'C02.3', 'Hai phần ba trước của lưỡi, phần không xác định', 'Anterior two-thirds of tongue, part unspecified', 23),
            array(503, 'C02.4', 'Hạnh nhân lưỡi', 'Lingual tonsil', 23),
            array(504, 'C02.8', 'Sang thương lan rộng của lưỡi', 'Overlapping lesion of tongue', 23),
            array(505, 'C03', 'U ác nướu răng', 'Malignant neoplasm of gum', 24),
            array(506, 'C03.0', 'Nướu hàm trên', 'Upper gum', 24),
            array(507, 'C03.0X', 'Niêm mạc mào xương ổ, nướu ', 'Maxilla, gingiva and aveolar ridge mucosa', 24),
            array(508, 'C03.1', 'Nướu hàm dưới', 'Lower gum', 24),
            array(509, 'C03.1X', 'Niêm mạc mào xương ổ, nướu', 'Mandible, gingiva and aveolar ridge mucosa', 24),
            array(510, 'C04', 'U ác sàn miệng', 'Malignant neoplasm of floor of mouth', 25),
            array(511, 'C04.0', 'Sàn miệng trước ', 'Anterior floor of mouth', 25),
            array(512, 'C04.1', 'Sàn miệng bên', 'Lateral floor of mouth', 25),
            array(513, 'C04.8', 'Sang thương lan rộng của sàn miệng', 'Overlapping lesion of floor of mouth', 25),
            array(514, 'C05', 'U ác khẩu cái', 'Malignant neoplasm of palate', 26),
            array(515, 'C05.0', 'Khẩu cái cứng', 'Hard palate', 26),
            array(516, 'C05.1', 'Khẩu cái mềm', 'Soft palate', 26),
            array(517, 'C05.2', 'Lưỡi gà', 'Uvula', 26),
            array(518, 'C06', 'U ác của phần khác và không xác định của miệng', 'Malignant neoplasm of other and unspecified parts of mouth', 27),
            array(519, 'C06.0', 'Niêm mạc má', 'Cheek mucosa', 27),
            array(520, 'C06.1', 'Tiền đình miệng', 'Vestibule of mouth', 27),
            array(521, 'C06.10', 'Đáy hành lang môi trên', 'Upper labial sulcus', 27),
            array(522, 'C06.11', 'Đáy hành lang má trên', 'Upper buccal sulcus', 27),
            array(523, 'C06.12', 'Đáy hành lang môi dưới', 'Lower labial sulcus', 27),
            array(524, 'C06.13', 'Đáy hành lang má dưới', 'Lower buccal sulcus', 27),
            array(525, 'C06.14', 'Đáy hành lang trên, không xác định ', 'Upper sulcus, unspecified', 27),
            array(526, 'C06.15', 'Đáy hành lang dưới, không xác định ', 'Lower sulcus, unspecified', 27),
            array(527, 'C06.2', 'Vùng sau răng hàm', 'Retromolar area', 27),
            array(528, 'C06.20', 'Lồi cùng hàm trên', 'Maxillary tuberosity ', 27),
            array(529, 'C06.21', 'Vùng tam giác hậu hàm hàm dưới', 'Mandibular retromolar area', 27),
            array(530, 'C07', 'U ác tuyến mang tai', 'Malignant neoplasm of parotid gland', 27),
            array(531, 'C08.0', 'U ác tuyến nước bọt dưới hàm ', 'Malignant neoplasm of submandibular gland', 27),
            array(532, 'C08.1', 'U ác tuyến nước bọt dưới lưỡi', 'Malignant neoplasm of sublingual gland', 27),
            array(533, 'C10.4', 'Khe mang', 'Branchial cleft', 27),
            array(534, 'C31.0', 'Xoang hàm', 'Maxillary sinus', 27),
            array(535, '', 'U ác tính ở xương và sụn khớp', 'Malignant neoplasm of bone and articular cartilage ', 27),
            array(536, 'C41', 'U ác của xương và sụn khớp ở vị trí khác và không xác định', 'Malignant neoplasm of bone and articular cartilage of other and unspecified sites', 28),
            array(537, 'C41.0', 'Xương sọ và mặt', 'Bones of skull and face', 28),
            array(538, 'C41.00', 'Xương hàm trên, sarcoma', 'Maxilla, sarcoma', 28),
            array(539, 'C41.01', 'Xương hàm trên, U do răng ác tính', 'Maxilla, malignant odontogenic tomour ', 28),
            array(540, '', 'Carcinoma xuất phát từ nang do răng ', 'Carcinoma arising in odontogenic cyst', 28),
            array(541, 'C41.02', 'Xương hàm trên, u tuyến nước bọt trong xương ác tính', 'Maxilla, malignant intraosseous salivary gland tumour', 28),
            array(542, 'C41.1', 'Xương hàm dưới', 'Mandible', 28),
            array(543, '', 'Bao gồm: xương hàm KXĐ', 'Includes: jaw NOS', 28),
            array(544, 'C41.10', 'Sarcoma', 'Sarcoma', 28),
            array(545, 'C41.11', 'U do răng ác tính', 'Malignant odontogenic tomour ', 28),
            array(546, '', 'Carcinoma xuất phát từ nang do răng ', 'Carcinoma arising in odontogenic cyst', 28),
            array(547, 'C41.12', 'U tuyến nước bọt trong xương ác tính', 'Malignant intraosseous salivary gland tumour', 28),
            array(548, 'C41.8', 'Sang thương lan rộng của xương và sụn khớp', 'Overlapping lesion of bone and articular cartilage', 28),
            array(549, '', 'Melanom và các u ác tính khác ở da', 'Melanoma  and other malignant neoplasms of skin ', 29),
            array(550, 'C43', 'Melanom ác của da', 'Malignant melanoma of skin', 29),
            array(551, 'C43.0', 'Melanom ác của môi', 'Malignant melanoma of lip', 29),
            array(552, 'C43.1', 'Melanom ác của mi mắt, bao gồm khoé mắt', 'Malignant melanoma of eyelid, including canthus', 29),
            array(553, 'C44', 'U ác khác của da', 'Other malignant neoplasms of skin', 29),
            array(554, 'C44.0', 'Da môi', 'Skin of lip', 29),
            array(555, 'C44.1', 'Da của mi mắt, bao gồm khoé mắt', 'Skin of eyelid, including canthus', 29),
            array(556, 'C44.3', 'Da của phần khác và không xác định của mặt', 'Skin of other and unspecified parts of face', 29),
            array(557, 'C44.4', 'Da đầu và da cổ', 'Skin of scalp and neck', 29),
            array(558, '', 'U ác tính của mô mềm và trung mô', 'Malignant neoplasms of mesothelial and soft tissue', 30),
            array(559, 'C46', 'Sarcom Kaposi', 'Kaposi\'s sarcoma', 30),
            array(560, 'C46.3', 'Sarcom Kaposi hạch lympho', 'Kaposi\'s sarcoma of lymph nodes', 30),
            array(561, 'C47', 'U ác của dây thần kinh ngoại biên và hệ thần kinh tự chủ ', 'Malignant neoplasm of peripheral nerves and autonomic nervous system', 31),
            array(562, 'C47.0', 'Dây thần kinh ngoại biên vùng đầu, mặt, cổ', 'Peripheral nerves of head, face and neck', 31),
            array(563, 'C49.0', 'U ác mô liên kết và mô mềm vùng đầu, mặt và cổ', 'Malignant neoplasm of connective and soft tissue of head, face and neck', 31),
            array(564, 'C79', 'U ác thứ phát vị trí khác', 'Secondary malignant neoplasm of other sites', 32),
            array(565, 'C79.2', 'U ác thứ phát ở da', 'Secondary malignant neoplasm of skin', 32),
            array(566, 'C79.2X', 'Mặt', 'Face', 32),
            array(567, '', 'Môi', 'Lip', 32),
            array(568, 'C79.5', 'U ác thứ phát của xương và tủy xương', 'Secondary malignant neoplasm of bone and bone marrow', 32),
            array(569, 'C79.50', 'Xương hàm trên', 'Maxilla', 32),
            array(570, 'C79.51', 'Xương hàm dưới ', 'Mandible', 32),
            array(571, '', 'Lồi cầu', 'Condyle', 32),
            array(572, 'C79.8', 'U ác thứ phát của các vị trí xác định khác', 'Secondary malignant neoplasm of other specified sites', 32),
            array(573, 'C79.8X', 'Mô miệng', 'Oral tissues', 32),
            array(574, '', 'Lưỡi', 'Tongue', 32),
            array(575, '', 'Carcinom  tại chỗ ', 'In situ neoplasms', 32),
            array(576, '', 'Bao gồm: bệnh Bowen', 'Includes: Bowen\'s disease', 32),
            array(577, '', 'hồng sản ', 'erythroplakia', 32),
            array(578, 'D00.0', 'Carcinom tại chỗ của Môi, khoang miệng và hầu', 'Carcinoma in situ of lip, oral cavity and pharynx', 33),
            array(579, 'D00.00', 'Niêm mạc môi và bờ viền môi ', 'labial mucosa and vermilion border', 33),
            array(580, 'D00.01', 'Niêm mạc má', 'Buccal mucosa', 33),
            array(581, 'D00.02', 'Nướu và mào xương ổ sóng hàm ', 'Gingiva and edentulous alveolar ridge', 33),
            array(582, 'D00.03', 'Khẩu cái', 'Palate', 33),
            array(583, 'D00.04', 'Sàn miệng', 'Floor of mouth', 33),
            array(584, 'D00.05', 'Mặt bụng lưỡi', 'Ventral surface of tongue', 33),
            array(585, 'D00.06', 'Phần khác của lưỡi, không phải bụng lưỡi', 'Tongue other than ventral surface', 33),
            array(586, 'D00.07', 'Hầu-miệng ', 'Oropharynx', 33),
            array(587, 'D03', 'Melanom tại chỗ', 'Melanoma in situ', 34),
            array(588, 'D03.0', 'Melanom tại chỗ của môi', 'Melanoma in situ of lip', 34),
            array(589, 'D03.0X', 'Niêm mạc môi và bờ viền môi ', 'labial mucosa and vermilion border', 34),
            array(590, 'D03.1', 'Melanom tại chỗ của mi mắt, bao gồm góc mắt', 'Melanoma in situ of eyelid, including canthus', 34),
            array(591, 'D03.3', 'Melanom tại chỗ của phần khác và phần không xác định của mặt', 'Melanoma in situ of other and unspecified parts of face', 34),
            array(592, 'D03.30', 'Da môi', 'Skin of lip', 34),
            array(593, 'D03.31', 'Da mặt khác', 'Other facial skin', 34),
            array(594, 'D03.4', 'Melanom tại chỗ của da đầu và cổ', 'Melanoma in situ of scalp and neck', 34),
            array(595, 'D03.8', 'Melanom tại chỗ của vị trí khác', 'Melanoma in situ of other sites', 34),
            array(596, 'D03.8X', 'Melanom tại chỗ niêm mạc miệng ', 'Melanoma in situ of oral mucosa', 34),
            array(597, 'D04', 'Carcinom tại chỗ của da', 'Carcinoma in situ of skin', 34),
            array(598, 'D04.0', 'Da môi', 'Skin of lip', 34),
            array(599, '', 'U lành của miệng và hầu', 'Benign neopiasm of mouth and pharynx', 35),
            array(600, 'D10.0', 'Môi', 'Lip', 35),
            array(601, 'D10.00', 'Môi trên, bờ viền môi ', 'Upper lip, vermilion border', 35),
            array(602, 'D10.01', 'Môi trên, niêm mạc môi', 'Upper lip, labial mucosa', 35),
            array(603, 'D10.02', 'Môi trên, bờ viền môi với niêm mạc', 'Upper lip, vermilion border with mucosa', 35),
            array(604, 'D10.03', 'Môi dưới, bờ viền môi ', 'Lower lip, vermilion border', 35),
            array(605, 'D10.04', 'Môi dưới, niêm mạc môi', 'Lower lip, labial mucosa', 35),
            array(606, 'D10.05', 'Môi dưới, bờ viền môi với niêm mạc', 'Lower lip, vermilion border with mucosa', 35),
            array(607, 'D10.06', 'Cả hai môi, bờ viền môi ', 'Both lips, vermilion border', 35),
            array(608, 'D10.07', 'Cả hai môi, niêm mạc môi', 'Both lips, labial mucosa', 35),
            array(609, 'D10.08', 'Cả hai môi, bờ viền môi với niêm mạc', 'Both lips, vermilion border with mucosa', 35),
            array(610, 'D10.1', 'Lưỡi', 'Tongue', 36),
            array(611, '', 'Bao gồm: U lành tính các tuyến nước bọt phụ', 'Includes:benign neoplasm of minor salivary glands ', 36),
            array(612, 'D10.10', 'Đáy lưỡi (phía sau rãnh tận cùng (V lưỡi))', 'Base of tongue (posterior to terminal sulcus)', 36),
            array(613, 'D10.11', 'Mặt lưng lưỡi', 'Dorsal surface of tongue', 36),
            array(614, 'D10.12', 'Bờ lưỡi và đầu lưỡi', 'Border and tip of tongue', 36),
            array(615, 'D10.13', 'Mặt bụng lưỡi', 'Ventral surface of tongue', 36),
            array(616, 'D10.14', 'Hạnh nhân lưỡi', 'Lingual tonsil', 36),
            array(617, 'D10.2', 'Sàn miệng', 'Floor of mouth', 36),
            array(618, 'D10.3', 'Phần khác và không xác định của miệng', 'Other and unspecified parts of mouth', 36),
            array(619, '', 'Bao gồm: u tuyến nước bọt phụ KXĐ', 'Includes: minor salivary gland NOS', 36),
            array(620, 'D10.30', 'Niêm mạc má', 'Buccal mucosa', 36),
            array(621, 'D10.31', 'Mép niêm mạc má', 'Buccal mucosa commissure', 36),
            array(622, 'D10.32', 'Ngách hành lang vùng má ', 'Buccal sulcus', 36),
            array(623, 'D10.33', 'Nước và sóng hàm ', 'Gingiva and edentulous alveolar ridge', 36),
            array(624, '', 'epulis bẩm sinh', 'Congenital epulis', 36),
            array(625, '', 'u hạt thai nghén (O26.8)', 'pregnancy granuloma (O26.8)', 36),
            array(626, 'D10.34', 'Khẩu cái cứng', 'Hard palate', 36),
            array(627, '', 'Vùng nối giữa khẩu cái cứng và mềm', 'Junction of hard and soft palate', 36),
            array(628, 'D10.35', 'Khẩu cái mềm', 'Soft palate', 36),
            array(629, 'D10.36', 'Lưỡi gà', 'Uvula', 36),
            array(630, 'D10.37', 'Vùng sau các răng cối', 'Retromolar area', 36),
            array(631, 'D10.38', 'Lồi cùng', 'Tuberosity', 36),
            array(632, 'D11.0', 'Tuyến mang tai', 'Parotid gland', 36),
            array(633, 'D11.70', 'Tuyến dưới hàm ', 'Submandibular gland', 36),
            array(634, 'D11.71', 'Tuyến dưới lưỡi', 'Sublingual gland', 36),
            array(635, 'D16', 'U lành của xương và sụn khớp', 'Benign neoplasm of bone and articular cartilage', 37),
            array(636, 'D16.40', 'Xương hàm trên, xương và sụn', 'Maxilla, bone and cartilage', 37),
            array(637, 'D16.41', 'Xương hàm trên, mô răng ', 'Maxilla, odontogenic tissues', 37),
            array(638, 'D16.5', 'Xương hàm dưới', 'Lower jaw bone', 37),
            array(639, 'D16.50', 'Xương hàm dưới, xương và sụn', 'Mandible, bone and cartilage', 37),
            array(640, 'D16.51', 'Xương hàm dưới, mô răng ', 'Mandible, odontogenic tissues', 37),
            array(641, 'D17', 'U mỡ', 'Benign lipomatous neoplasm', 37),
            array(642, 'D18', 'U mạch máu và U bạch mạch, vị trí bất kỳ', 'Haemangioma and lymphangioma, any site', 37),
            array(643, 'D18.0', 'U mạch máu, vị trí bất kỳ', 'Haemangioma, any site', 37),
            array(644, 'D18.1', 'U bạch mạch vị trí bất kỳ', 'Lymphangioma, any site', 37),
            array(645, 'D21.0', 'U lành mô liên kết và mô mềm khác của đầu, mặt và cổ', 'Connective and other soft tissue of head, face and neck', 37),
            array(646, '', 'U lành của mạch máu không phải u máu và u tiểu thể thần kinh ', 'Benign tumours of blood vessels other than haemangioma and glomus tomour', 37),
            array(647, '', 'U cơ trơn ', 'Leiomyoma', 37),
            array(648, '', 'U cơ vân ', 'Rhabdomyoma', 37)
        );
        foreach ($data as $value) {
            $infoArr = array_values($value);
            $model = new Diagnosis();
            
            $model->code = isset($infoArr[1]) ? $infoArr[1] : '-';
            $model->name = isset($infoArr[2]) ? $infoArr[2] : '';
            $model->name_en = isset($infoArr[3]) ? $infoArr[3] : '';
            $model->parent_id = isset($infoArr[4]) ? $infoArr[4] : '0';
            if ($model->parent_id == '0') {
                $model->id = $infoArr[0];
            }
            $model->description = '';
            $model->save();
        }
    }
    
    public static function importStreet() {
        $data = array(
//            2 => array(
//                array(1, 1, 'Phạm Ngọc Thạch', 'pham ngoc thach', 'pham-ngoc-thach', 2, 1),
//                array(4, 1, 'Võ Văn Ngân', 'vo van ngan', 'vo-van-ngan', 2, 1),
//                array(5, 1, 'Hùng Vương', 'hung vuong', 'hung-vuong', 2, 1),
//                array(6, 1, 'Bông Sao', 'bong sao', 'bong-sao', 2, 1),
//                array(7, 1, 'Lê Văn Việt', 'le van viet', 'le-van-viet', 2, 1),
//                array(8, 1, 'Đặng Văn Bi', 'dang van bi', 'dang-van-bi', 2, 1),
//                array(9, 1, 'Tô Ngọc Vân', 'to ngoc van', 'to-ngoc-van', 2, 1),
//                array(10, 1, 'Thống Nhất', 'thong nhat', 'thong-nhat', 2, 1),
//                array(11, 1, 'Đinh Tiên Hoàng', 'dinh tien hoang', 'dinh-tien-hoang', 2, 1),
//                array(12, 1, 'Nguyễn Đình Chiểu', 'nguyen dinh chieu', 'nguyen-dinh-chieu', 2, 1),
//                array(13, 1, 'Nguyễn Thị Minh Khai', 'nguyen thi minh khai', 'nguyen-thi-minh-khai', 2, 1),
//                array(14, 1, 'Cách Mạng Tháng 8', 'cach mang thang 8', 'cach-mang-thang-8', 2, 1),
//                array(15, 1, 'Nguyễn Trãi', 'nguyen trai', 'nguyen-trai', 2, 1),
//                array(16, 1, 'Nguyễn Du', 'nguyen du', 'nguyen-du', 2, 1),
//                array(17, 1, 'Lê Duẩn', 'le duan', 'le-duan', 2, 1),
//                array(18, 1, 'Điện Biên Phủ', 'dien bien phu', 'dien-bien-phu', 2, 1),
//                array(19, 1, 'Xô Viết Nghệ Tĩnh', 'xo viet nghe tinh', 'xo-viet-nghe-tinh', 2, 1),
//                array(20, 1, 'Phan Đình Phùng', 'phan dinh phung', 'phan-dinh-phung', 2, 1),
//                array(21, 1, 'Nam Kỳ Khởi Nghĩa', 'nam ky khoi nghia', 'nam-ky-khoi-nghia', 2, 1),
//                array(22, 1, 'Bùi Hữu Nghía', 'bui huu nghia', 'bui-huu-nghia', 2, 1),
//                array(23, 1, 'Trần Quang Khải', 'tran quang khai', 'tran-quang-khai', 2, 1),
//                array(24, 1, 'Âu Cơ', 'au co', 'au-co', 2, 1),
//                array(25, 1, 'Lạc Long Quân', 'lac long quan', 'lac-long-quan', 2, 1),
//                array(26, 1, 'Hai Bà Trưng', 'hai ba trung', 'hai-ba-trung', 2, 1),
//                array(27, 1, 'Hoàng Diệu 2', 'hoang dieu 2', 'hoang-dieu-2', 2, 1),
//                array(28, 1, 'Bình Quới', 'binh quoi', 'binh-quoi', 2, 1),
//                array(29, 1, 'Tạ Quang Bửu', 'ta quang buu', 'ta-quang-buu', 2, 1),
//                array(30, 1, 'Âu Dương Lân', 'au duong lan', 'au-duong-lan', 2, 1),
//                array(31, 1, 'Phạm Thế Hiển', 'pham the hien', 'pham-the-hien', 2, 1),
//                array(32, 1, 'Huỳnh Tấn Phát', 'huynh tan phat', 'huynh-tan-phat', 2, 1),
//                array(33, 1, 'Đỗ Xuân Hợp', 'do xuan hop', 'do-xuan-hop', 2, 1),
//                array(34, 1, 'Nguyễn Cửu Vân', 'nguyen cuu van', 'nguyen-cuu-van', 2, 1),
//                array(35, 1, 'Nguyễn Hửu Cảnh', 'nguyen huu canh', 'nguyen-huu-canh', 2, 1),
//                array(36, 1, 'Hồng Bàng', 'hong bang', 'hong-bang', 2, 1),
//                array(37, 1, 'Bạch Đằng', 'bach dang', 'bach-dang', 2, 1),
//                array(38, 1, 'Nguyễn Xí', 'nguyen xi', 'nguyen-xi', 2, 1),
//                array(39, 1, 'Phạm Văn Đồng', 'pham van dong', 'pham-van-dong', 2, 1),
//                array(40, 1, 'Nguyễn Thị Thập', 'nguyen thi thap', 'nguyen-thi-thap', 2, 1),
//                array(41, 1, 'Trần Não', 'tran nao', 'tran-nao', 2, 1),
//                array(42, 1, 'Võ Văn Kiệt', 'vo van kiet', 'vo-van-kiet', 2, 1),
//                array(43, 1, 'Lương Đình Của', 'luong dinh cua', 'luong-dinh-cua', 2, 1),
//                array(44, 1, 'Ung Văn Khiêm', 'ung van khiem', 'ung-van-khiem', 2, 1),
//                array(45, 1, 'D1', 'd1', 'd1', 2, 1),
//                array(46, 1, 'D2', 'd2', 'd2', 2, 1),
//                array(47, 1, 'D3', 'd3', 'd3', 2, 1),
//                array(48, 1, 'D5', 'd5', 'd5', 2, 1),
//                array(49, 1, '3 Tháng 2', '3 thang 2', '3-thang-2', 2, 1),
//                array(50, 1, 'Tôn Đức Thắng', 'ton duc thang', 'ton-duc-thang', 2, 1),
//                array(51, 1, 'Phan Đăng Lưu', 'phan dang luu', 'phan-dang-luu', 2, 1),
//                array(52, 1, 'Ngô Tất Tố', 'ngo tat to', 'ngo-tat-to', 2, 1),
//                array(53, 1, 'Trần Đại Nghĩa', 'tran dai nghia', 'tran-dai-nghia', 2, 1),
//                array(54, 1, 'Phạm Hùng', 'pham hung', 'pham-hung', 2, 1),
//                array(55, 1, 'Chánh Hưng', 'chanh hung', 'chanh-hung', 2, 1),
//                array(56, 1, 'Nguyễn Tất Thành', 'nguyen tat thanh', 'nguyen-tat-thanh', 2, 1),
//                array(57, 1, 'Mai Chi Thọ', 'mai chi tho', 'mai-chi-tho', 2, 1),
//                array(58, 1, 'Nguyễn Bỉnh Khiêm', 'nguyen binh khiem', 'nguyen-binh-khiem', 2, 1),
//                array(59, 1, 'Trường Sa', 'truong sa', 'truong-sa', 2, 1),
//                array(60, 1, 'Hoàng Sa', 'hoang sa', 'hoang-sa', 2, 1),
//                array(61, 1, 'Phan Văn Hân', 'phan van han', 'phan-van-han', 2, 1),
//                array(62, 1, 'Nguyễn Văn Lạc', 'nguyen van lac', 'nguyen-van-lac', 2, 1),
//                array(63, 1, 'Nguyễn Công Trứ', 'nguyen cong tru', 'nguyen-cong-tru', 2, 1),
//                array(64, 1, 'Phạm Viết Chánh', 'pham viet chanh', 'pham-viet-chanh', 2, 1),
//                array(65, 1, 'Phan Huy Ôn', 'phan huy on', 'phan-huy-on', 2, 1),
//                array(66, 1, 'Đinh Bộ Lĩnh', 'dinh bo linh', 'dinh-bo-linh', 2, 1),
//                array(67, 1, 'Phan Bội Châu', 'phan boi chau', 'phan-boi-chau', 2, 1),
//                array(68, 1, 'Phan Châu Trinh', 'phan chau trinh', 'phan-chau-trinh', 2, 1),
//                array(69, 1, 'Bùi Đình Túy', 'bui dinh tuy', 'bui-dinh-tuy', 2, 1),
//                array(70, 1, 'Kha Vạn Cân', 'kha van can', 'kha-van-can', 2, 1),
//                array(71, 1, 'Lê Quang Định', 'le quang dinh', 'le-quang-dinh', 2, 1),
//                array(72, 1, 'Thảo Điền', 'thao dien', 'thao-dien', 2, 1),
//                array(73, 1, 'Xuân Thủy', 'xuan thuy', 'xuan-thuy', 2, 1),
//                array(74, 1, 'Nguyễn Duy Trinh', 'nguyen duy trinh', 'nguyen-duy-trinh', 2, 1),
//                array(75, 1, 'Nguyễn Thị Định', 'nguyen thi dinh', 'nguyen-thi-dinh', 2, 1),
//                array(76, 1, 'Song Hành Hà Nội', 'song hanh ha noi', 'song-hanh-ha-noi', 2, 1),
//                array(77, 1, 'Nguyễn Văn Ba', 'nguyen van ba', 'nguyen-van-ba', 2, 1),
//                array(78, 1, 'Nguyễn Huệ', 'nguyen hue', 'nguyen-hue', 2, 1),
//                array(79, 1, 'Võ Thị Sáu', 'vo thi sau', 'vo-thi-sau', 2, 1),
//                array(80, 1, 'Võ Văn Tần', 'vo van tan', 'vo-van-tan', 2, 1),
//                array(81, 1, 'Đồng Khởi', 'dong khoi', 'dong-khoi', 2, 1),
//                array(82, 1, 'Phạm Văn Chiêu', 'pham van chieu', 'pham-van-chieu', 2, 1),
//                array(83, 1, 'Quang Trung', 'quang trung', 'quang-trung', 2, 1),
//                array(84, 1, 'Phan Văn Trị', 'phan van tri', 'phan-van-tri', 2, 1),
//                array(85, 1, 'Phan Huy Ích', 'phan huy ich', 'phan-huy-ich', 2, 1),
//                array(86, 1, 'Trường Chinh', 'truong chinh', 'truong-chinh', 2, 1),
//                array(87, 1, 'Lê Trọng Tấn', 'le trong tan', 'le-trong-tan', 2, 1),
//                array(88, 1, 'Tân Kỳ Tân Quý', 'tan ky tan quy', 'tan-ky-tan-quy', 2, 1),
//                array(89, 1, 'Trần Văn Giàu', 'tran van giau', 'tran-van-giau', 2, 1),
//                array(90, 1, 'Kinh Dương Vương', 'kinh duong vuong', 'kinh-duong-vuong', 2, 1),
//                array(91, 1, 'Cộng Hòa', 'cong hoa', 'cong-hoa', 2, 1),
//                array(92, 1, 'Nơ Trang Long', 'no trang long', 'no-trang-long', 2, 1),
//                array(93, 1, 'Lý Thường Kiệt', 'ly thuong kiet', 'ly-thuong-kiet', 2, 1),
//                array(94, 1, 'Nguyễn Hữu Thọ', 'nguyen huu tho', 'nguyen-huu-tho', 2, 1),
//                array(95, 1, 'Tân Tạo', 'tan tao', 'tan-tao', 2, 1),
//                array(96, 1, 'Công Lý', 'cong ly', 'cong-ly', 2, 1),
//                array(97, 1, 'Đoàn Kết', 'doan ket', 'doan-ket', 2, 1),
//                array(98, 1, 'Trần Xuân Soạn', 'tran xuan soan', 'tran-xuan-soan', 2, 1),
//                array(99, 1, 'An Dương Vương', 'an duong vuong', 'an-duong-vuong', 2, 1),
//                array(100, 1, 'Tôn Thất Thuyết', 'ton that thuyet', 'ton-that-thuyet', 2, 1),
//                array(101, 1, 'Tùng Thiện Vương', 'tung thien vuong', 'tung-thien-vuong', 2, 1),
//                array(103, 1, 'Trần Phú', 'tran phu', 'tran-phu', 2, 1),
//                array(104, 1, 'Nguyễn Chí Thanh', 'nguyen chi thanh', 'nguyen-chi-thanh', 2, 1),
//                array(105, 1, 'Lê Đại Hành', 'le dai hanh', 'le-dai-hanh', 2, 1),
//                array(106, 1, 'Nguyễn Duy', 'nguyen duy', 'nguyen-duy', 2, 1),
//                array(107, 1, 'Nguyễn Văn Linh', 'nguyen van linh', 'nguyen-van-linh', 2, 1),
//                array(108, 1, 'Hàm Nghi', 'ham nghi', 'ham-nghi', 2, 1),
//                array(109, 1, 'Thích Quảng Đức', 'thich quang duc', 'thich-quang-duc', 2, 1),
//                array(110, 1, 'Đào Duy Anh', 'dao duy anh', 'dao-duy-anh', 2, 1),
//                array(111, 1, 'Hồ Văn Huê', 'ho van hue', 'ho-van-hue', 2, 1),
//                array(112, 1, 'Bình Lợi', 'binh loi', 'binh-loi', 2, 1),
//                array(113, 1, 'Linh Đông', 'linh dong', 'linh-dong', 2, 1),
//                array(114, 1, 'Lê Văn Thọ', 'le van tho', 'le-van-tho', 2, 1),
//                array(115, 1, 'Lê Văn Quới', 'le van quoi', 'le-van-quoi', 2, 1),
//                array(116, 1, 'Thành Thái', 'thanh thai', 'thanh-thai', 2, 1),
//                array(117, 1, 'Nguyễn Văn Trỗi', 'nguyen van troi', 'nguyen-van-troi', 2, 1),
//                array(118, 1, 'Nguyễn Kiệm', 'nguyen kiem', 'nguyen-kiem', 2, 1),
//                array(119, 1, 'Nguyễn Văn Lượng', 'nguyen van luong', 'nguyen-van-luong', 2, 1),
//                array(120, 1, 'Nguyễn Lương Bằng', 'nguyen luong bang', 'nguyen-luong-bang', 2, 1),
//                array(121, 1, 'Hoàng Hữu Nam', 'hoang huu nam', 'hoang-huu-nam', 2, 1),
//                array(122, 1, 'Phan Văn Hớn', 'phan van hon', 'phan-van-hon', 2, 1),
//                array(123, 1, 'Nguyễn Thái Sơn', 'nguyen thai son', 'nguyen-thai-son', 2, 1),
//                array(124, 1, 'Bến Chương Dương', 'ben chuong duong', 'ben-chuong-duong', 2, 1),
//                array(125, 1, 'Hoàng Văn Thụ', 'hoang van thu', 'hoang-van-thu', 2, 1),
//                array(126, 1, 'Nguyễn Tri Phương', 'nguyen tri phuong', 'nguyen-tri-phuong', 2, 1),
//                array(127, 1, 'Nguyễn Văn Cừ', 'nguyen van cu', 'nguyen-van-cu', 2, 1),
//                array(128, 1, 'Lý Thái Tổ', 'ly thai to', 'ly-thai-to', 2, 1),
//                array(129, 1, 'Ông Ích Khiêm', 'ong ich khiem', 'ong-ich-khiem', 2, 1),
//                array(130, 1, 'Ngô Gia Tự', 'ngo gia tu', 'ngo-gia-tu', 2, 1),
//                array(131, 1, 'Nguyễn Hữu Trí', 'nguyen huu tri', 'nguyen-huu-tri', 2, 1),
//                array(132, 1, 'Mạc Đĩnh Chi', 'mac dinh chi', 'mac-dinh-chi', 2, 1),
//                array(133, 1, 'Trần Cao Vân', 'tran cao van', 'tran-cao-van', 2, 1),
//                array(134, 1, 'Phùng Khắc Khoan', 'phung khac khoan', 'phung-khac-khoan', 2, 1),
//                array(135, 1, 'Nguyễn Huy Tự', 'nguyen huy tu', 'nguyen-huy-tu', 2, 1),
//                array(136, 1, 'Phan Liêm', 'phan liem', 'phan-liem', 2, 1),
//                array(137, 1, 'Huỳnh Khương Ninh', 'huynh khuong ninh', 'huynh-khuong-ninh', 2, 1),
//                array(138, 1, 'Đinh Công Tráng', 'dinh cong trang', 'dinh-cong-trang', 2, 1),
//                array(139, 1, 'Nguyễn Hữu Cầu', 'nguyen huu cau', 'nguyen-huu-cau', 2, 1),
//                array(140, 1, 'Trần Nhật Duật', 'tran nhat duat', 'tran-nhat-duat', 2, 1),
//                array(141, 1, 'Trần Khắc Chân', 'tran khac chan', 'tran-khac-chan', 2, 1),
//                array(142, 1, 'Trần Khánh Dư', 'tran khanh du', 'tran-khanh-du', 2, 1),
//                array(143, 1, 'Thạch Thị Thanh', 'thach thi thanh', 'thach-thi-thanh', 2, 1),
//                array(144, 1, 'Lê Thánh Tôn', 'le thanh ton', 'le-thanh-ton', 2, 1),
//                array(145, 1, 'Hồ Đắc Di', 'ho dac di', 'ho-dac-di', 2, 1),
//                array(146, 1, 'Tạo Lực', 'tao luc', 'tao-luc', 2, 1),
//                array(147, 1, 'Bến Vân Đồn', 'ben van don', 'ben-van-don', 2, 1),
//                array(148, 1, 'Dương Bá Trạc', 'duong ba trac', 'duong-ba-trac', 2, 1),
//                array(149, 1, 'Sư Vạn Hạnh', 'su van hanh', 'su-van-hanh', 2, 1),
//                array(150, 1, 'Lãnh Binh Thăng', 'lanh binh thang', 'lanh-binh-thang', 2, 1),
//                array(151, 1, 'Lê Hồng Phong', 'le hong phong', 'le-hong-phong', 2, 1),
//                array(152, 1, 'Tân Duy', 'tan duy', 'tan-duy', 2, 1),
//                array(153, 1, 'Lữ Gia', 'lu gia', 'lu-gia', 2, 1),
//                array(154, 1, 'Phạm Văn Bạch', 'pham van bach', 'pham-van-bach', 2, 1),
//                array(155, 1, 'Lê Văn Miến', 'le van mien', 'le-van-mien', 2, 1),
//                array(156, 1, 'Đặng Hữu Phố', 'dang huu pho', 'dang-huu-pho', 2, 1),
//                array(157, 1, 'Nguyễn Văn Hưởng', 'nguyen van huong', 'nguyen-van-huong', 2, 1),
//                array(158, 1, 'Trần Ngọc Diện', 'tran ngoc dien', 'tran-ngoc-dien', 2, 1),
//                array(159, 1, 'Bùi Tá Hán', 'bui ta han', 'bui-ta-han', 2, 1),
//                array(160, 1, 'Vũ Tông Phan', 'vu tong phan', 'vu-tong-phan', 2, 1),
//                array(161, 1, 'Nguyễn Hoàng', 'nguyen hoang', 'nguyen-hoang', 2, 1),
//                array(162, 1, 'Dương Văn An', 'duong van an', 'duong-van-an', 2, 1),
//                array(163, 1, 'Trần Lưu', 'tran luu', 'tran-luu', 2, 1),
//                array(164, 1, 'Vạn Kiếp', 'van kiep', 'van-kiep', 2, 1),
//                array(165, 1, 'Hoa Lan', 'hoa lan', 'hoa-lan', 2, 1),
//                array(166, 1, 'Nguyễn Văn Nghi', 'nguyen van nghi', 'nguyen-van-nghi', 2, 1),
//                array(167, 1, 'Hồng Hà', 'hong ha', 'hong-ha', 2, 1),
//                array(168, 1, 'Đặng Văn Ngữ', 'dang van ngu', 'dang-van-ngu', 2, 1),
//                array(169, 1, 'Phạm Văn Hai', 'pham van hai', 'pham-van-hai', 2, 1),
//                array(170, 1, 'Nguyễn Phúc Chu', 'nguyen phuc chu', 'nguyen-phuc-chu', 2, 1),
//                array(171, 1, 'Trần Thái Tông', 'tran thai tong', 'tran-thai-tong', 2, 1),
//                array(172, 1, 'Lam Sơn', 'lam son', 'lam-son', 2, 1),
//                array(173, 1, 'Yên Thế', 'yen the', 'yen-the', 2, 1),
//                array(174, 1, 'Tân Hòa Đông', 'tan hoa dong', 'tan-hoa-dong', 2, 1),
//                array(175, 1, 'Hương Lộ 2', 'huong lo 2', 'huong-lo-2', 2, 1),
//                array(176, 1, 'Tân Sơn Nhì', 'tan son nhi', 'tan-son-nhi', 2, 1),
//                array(177, 1, 'Phạm Phú Thứ', 'pham phu thu', 'pham-phu-thu', 2, 1),
//                array(178, 1, 'Thoại Ngọc Hầu', 'thoai ngoc hau', 'thoai-ngoc-hau', 2, 1),
//                array(179, 1, 'Hoàng Hoa Thám', 'hoang hoa tham', 'hoang-hoa-tham', 2, 1),
//                array(180, 1, 'Phạm Ngũ Lão', 'pham ngu lao', 'pham-ngu-lao', 2, 1),
//                array(181, 1, 'Hà Huy Giáp', 'ha huy giap', 'ha-huy-giap', 2, 1),
//                array(182, 1, 'Nguyễn Oanh', 'nguyen oanh', 'nguyen-oanh', 2, 1),
//                array(183, 1, 'Lê Thị Riêng', 'le thi rieng', 'le-thi-rieng', 2, 1),
//                array(184, 1, 'Lê Đức Thọ', 'le duc tho', 'le-duc-tho', 2, 1)
//            ),
            4   => array(
                "Cao Thắng",
                "Lê Đình Lý",
                "Hùng Vương",
                "Lê Lợi",
                "3.2",
                "Nguyễn Chí Thanh",
                "Phan Châu Trinh",
                "Tiểu La",
                "2.9",
                "Quang Trung",
                "Đống Đa",
                "Nguyễn Du",
                "Lý Tự Trọng",
                "Hoàng Diệu",
                "Ông Ích Khiêm",
                "Nguyễn Hoàng",
                "Thái Phiên",
                "Lê Hồng Phong",
                "Hoàng Văn Thụ",
                "Yên Bái",
                "Trưng Nữ Vương",
                "Ngô Gia Tự",
                "Triệu Nữ Vương",
                "Cao Thắng",
                "Bắc Đẩu",
                "Hải Hồ",
                "Pasteur",
                "Lê Đình Dương",
                "Nguyễn Văn Linh",
                "Lê Thanh Nghị",
                "Xô Viết Nghệ Tĩnh",
                "Trần Phú",
                "Bạch Đằng",
                "Nguyễn Tất Thành",
                "Thái Thị Bôi",
                "Lê Độ",
                "Trường Chinh",
                "Hải Phòng",
                "Điện Biên Phủ",
                "Hà Huy Tập",
                "Trần Cao Vân",
                "Nguyễn Tri Phương",
                "Lê Lợi",
                "Hùng Vương",
                "Lê Đình Lý",
                "Duy Tân",
                "Tiểu La",
                "Nguyễn Phước Nguyên",
                "Xô Viết Nghệ Tĩnh",
                "2.9",
                "Nguyễn Lương Bằng",
                "Nguyễn tất Thành",
                "Bàu Tràm",
                "Âu Cơ",
                "Đoàn Phú Thứ",
                "Nam Cao",
                "Lạc Long Quân",
                "Nguyễn Sinh Sắc",
                "Kinh Dương Vương",
                "Nguyên Chánh",
                "Trần Đình Tri",
                "Hoàng Văn Thái",
                "Tố Hữu",
                "Tôn Đức Thắng",
                "Yết Kiêu",
                "Lý Tử Tấn",
                "Hoàng Sa",
                "Lê Đức Thọ",
                "Phan Bá Phiến",
                "Trần Nhân Tông",
                "Trương Định",
                "Chu Huy Mân",
                "Nại Hiên Đông",
                "Dương Lâm",
                "Lê Văn Duyệt",
                "Dương Vân Nga",
                "Lê Chân",
                "Lý Đạo Hành",
                "Ngô Quyền",
                "Lê Văn Thứ",
                "Võ Nguyên Giáp",
                "Hồ Nghinh",
                "Nguyễn Công Trứ",
                "Võ Văn Kiệt",
                "Lê Hữu Trác",
                "Nguyễn Văn Thoại",
                "Trần Hưng Đạo",
                "Lê Văn Duyệt",
                "Võ Nguyên Giáp",
                "Lê Quang Đạo",
                "Châu Thị Vĩnh tế",
                "Phan Tứ",
                "Trần Văn Dư",
                "Hồ Xuân Hương",
                "Bà Huyện Thanh Quan",
                "Võ Như Hưng",
                "Hoài Thanh",
                "An Dương Vương",
                "Phạm Hữu Kính",
                "Lê Văn Hưu",
                "Hồ Huân Nghiệp",
                "Nguyễn Lữ",
                "Đoàn Khuê",
                "Trịnh Lỗi",
                "Nghiêm Xuân yêm",
                "Minh Mạng",
                "Nguyễn Xiến",
                "Trường Sa",
                "Nguyễn Duy Trinh",
                "Mai Đăng Chơn",
                "Võ Chí Công",
                "Phạm Đức Nam",
                "Lê Quát",
                "Trường Chinh",
                "Tôn Đản",
                "Lê Trọng Tấn",
                "Lê Đại Hành",
                "Xô Viết Nghệ Tĩnh",
                "Thăng Long",
                "Phạm Tứ",
                "Phan Khôi",
                "Lê Quang Định",
                "Trần Nam Trung",
                "Võ Chí Công",
                "Hồ Sĩ Dương",
                "Quốc lộ 14B"
            ),
        );
        
        foreach ($data as $key => $value) {
            foreach ($value as $street) {
//                $infoArr = array_values($street);
                $model = new Streets();
//                CommonProcess::dumpVariable($infoArr[2]);
//                $model->name = $infoArr[2];
//                $model->short_name = $infoArr[3];
//                $model->slug = $infoArr[4];
                $model->name = $street;
                $model->short_name = CommonProcess::getShortString($street);
                $model->slug = CommonProcess::getSlugString($street);
                $model->city_id = $key;
                $model->save();
            }
        }
    }
    
    public static function importTreatmentType() {
        $data = array(
            array(49, NULL, 'Điều trị nha chu', 400000, 1, 2, '', 0, 0, '', NULL, NULL),
            array(50, NULL, 'Hàm khung', 0, 1, 23, '', 0, 0, '', NULL, NULL),
            array(51, NULL, 'Răng nhựa', 0, 1, 23, '', 0, 0, '', NULL, NULL),
            array(52, NULL, 'Răng sứ Mỹ', 1000000, 1, 20, '', 0, 0, '', NULL, NULL),
            array(53, NULL, 'Niềng răng mắc cài kim loại', 15000000, 1, 18, '', 0, 0, '', NULL, NULL),
            array(54, NULL, 'Tẩy trắng tại nhà', 1200000, 1, 11, '', 0, 0, '', NULL, NULL),
            array(55, NULL, 'Nhổ răng người lớn', 0, 1, 22, '', 0, 0, '', NULL, NULL),
            array(56, NULL, 'Nhổ răng trẻ em', 0, 1, 22, '', 0, 0, '', NULL, NULL),
            array(57, NULL, 'Trám răng', 0, 1, 22, '', 0, 0, '', NULL, NULL),
            array(58, NULL, 'Cắt túi nha chu', 200000, 1, 2, '', 0, 0, '', NULL, NULL),
            array(59, NULL, 'Răng sứ ceramco', 1200000, 1, 20, '', 0, 0, '', NULL, NULL),
            array(60, NULL, 'Răng sứ titan', 2200000, 1, 20, '', 0, 0, '', NULL, NULL),
            array(61, NULL, 'Răng sứ ziconia', 4000000, 1, 20, '', 0, 0, '', NULL, NULL),
            array(62, NULL, 'Răng sứ kim loại quý', 250, 2, 20, '', 0, 0, '', NULL, NULL),
            array(63, NULL, 'Răng sứ cercon( toàn sứ)', 5000000, 1, 20, '', 0, 0, '', NULL, NULL),
            array(64, NULL, 'Tẩy trắng bằng đen platmas', 1200000, 1, 11, '', 0, 0, '', NULL, NULL),
            array(65, NULL, 'Niềng răng mắc cài sứ', 25000000, 1, 18, '', 0, 0, '', NULL, NULL),
            array(66, NULL, 'cạo vôi răng', 100000, 1, 2, '', 0, 0, '', NULL, NULL),
            array(67, NULL, 'Nhổ răng số 8', 500000, 1, 26, '', 0, 0, '', NULL, NULL),
            array(68, NULL, 'Nhổ răng thường', 100000, 1, 26, '', 0, 0, '', NULL, NULL),
            array(69, NULL, 'Trám răng thường', 120000, 1, 24, '', 0, 0, '', NULL, NULL),
            array(70, NULL, 'Trám răng thẩm mỹ', 150000, 1, 24, '', 0, 0, '', NULL, NULL),
            array(71, NULL, 'Răng hàm giả tháo lắp composite', 400000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(72, NULL, 'Răng hàm giả tháo lắp sứ', 500000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(73, NULL, 'cấy ghép inplant', 1000, 2, 28, '', 0, 0, '', NULL, NULL),
            array(74, NULL, 'Chữa tủy răng cửa', 300000, 1, 29, '', 0, 0, '', NULL, NULL),
            array(75, NULL, 'Chữa tủy răng cối', 400000, 1, 29, '', 0, 0, '', NULL, NULL),
            array(76, NULL, 'Chữa tủy răng mọc nghiêng ', 600000, 1, 29, '', 0, 0, '', NULL, NULL),
            array(77, NULL, 'Đính Kim Cương', 300000, 1, 30, '', 0, 0, '', NULL, NULL),
            array(78, NULL, 'Răng tháo lắp nhật', 200000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(79, NULL, 'hàm khung kim loại tháo lắp', 1500000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(80, NULL, 'rang su vita(toan su)', 6000000, 1, 20, '', 0, 0, '', NULL, NULL),
            array(81, NULL, 'rang inox', 1500000, 1, 20, '', 0, 0, '', NULL, NULL),
            array(82, NULL, 'Răng Emax ', 4000000, 1, 20, '', 0, 0, '', NULL, NULL),
            array(83, NULL, 'Chỉnh hàm', 200000, 1, 36, '', 0, 0, '', NULL, NULL),
            array(84, NULL, 'Full Emax', 2500000, 1, 37, '', 0, 0, '', NULL, NULL),
            array(85, NULL, 'Full Ziconia', 2500000, 1, 37, '', 0, 0, '', NULL, NULL),
            array(87, NULL, 'Vá hàm', 200000, 1, 38, '', 0, 0, '', NULL, NULL),
            array(88, NULL, 'Gắn Răng Kết Thúc', 300000, 1, 33, '', 0, 0, '', 1, NULL),
            array(89, NULL, 'cạo vôi răng 1', 120000, 1, 2, '', 0, 0, '', NULL, NULL),
            array(90, NULL, 'Nhổ răng người lớn', 600000, 1, 26, '', 0, 0, '', NULL, NULL),
            array(91, NULL, 'Chữa tủy răng người lớn', 800000, 1, 29, '', 0, 0, '', NULL, NULL),
            array(92, NULL, 'Trám răng người lớn', 200000, 1, 24, '', 0, 0, '', NULL, NULL),
            array(93, NULL, 'Nhổ răng tiểu phẫu', 1000000, 1, 26, '', 0, 0, '', NULL, NULL),
            array(94, NULL, 'Răng tháo lắp composite 1', 500000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(95, NULL, 'Làm khí cụ', 7000000, 1, 18, '', 0, 0, '', NULL, NULL),
            array(96, NULL, 'Tẩy trắng bằng thuốc tốt', 2500000, 1, 11, '', 0, 0, '', NULL, NULL),
            array(97, NULL, 'Nhổ chân răng', 200000, 1, 26, '', 0, 0, '', NULL, NULL),
            array(98, NULL, 'Hàm lưới', 1000000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(99, NULL, 'Răng tháo lắp sứ', 800000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(100, NULL, 'Cắm ghép implant', 30000000, 1, 28, '', 0, 0, '', NULL, NULL),
            array(101, NULL, 'Răng cercon HT', 5900000, 1, 20, '', 0, 0, '', NULL, NULL),
            array(102, NULL, 'Răng tháo lắp Vita', 1000000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(103, NULL, 'Bán nước súc miệng Kin', 150000, 1, 2, '', 0, 0, '', NULL, NULL),
            array(104, NULL, 'Bán syndent', 30000, 1, 2, '', 0, 0, '', NULL, NULL),
            array(105, NULL, 'Bán 1 Nogensol', 200000, 1, 2, '', 0, 0, '', NULL, NULL),
            array(106, NULL, 'Bán nước súc miệng senkin', 175000, 1, 2, '', 0, 0, '', NULL, NULL),
            array(107, NULL, 'Răng tháo lắp composite Vitapan', 650000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(108, NULL, 'Hàm khung kim loại', 3000000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(109, NULL, 'Hàm khung hàm dẻo', 3000000, 1, 27, '', 0, 0, '', NULL, NULL),
            array(110, '', 'Bán 1 SenSiKin', 180000, 1, 2, '', 0, 0, '', 0, ''),
            array(111, '', 'Máng tẩy trắng', 300000, 1, 11, '', 0, 0, '', 0, ''),
            array(112, '', 'Bán chỉ nha khoa', 60000, 1, 2, '', 0, 0, '', 0, ''),
            array(113, '', 'Cắt chóp', 1000000, 1, 29, '', 0, 0, '', 0, ''),
            array(114, '', '', 0, 1, 26, '', 0, 0, '', 0, ''),
            array(115, '', 'Nhổ răng tiểu phẫu ', 3000000, 1, 26, '', 0, 0, '', 0, ''),
            array(116, '', 'Niềng răng loại tốt', 35000000, 1, 18, '', 0, 0, '', 0, ''),
            array(117, '', 'Bán keo dán hàm', 250000, 1, 38, '', 0, 0, '', 0, ''),
            array(118, '', 'Răng sứ Zico trên Implant', 7000000, 1, 28, '', 0, 0, '', 0, ''),
            array(119, '', 'Hàm dẻo', 2000000, 1, 27, '', 0, 0, '', 0, ''),
            array(120, '', '', 1000000, 1, 29, '', 0, 0, '', 0, ''),
            array(121, '', 'Chữa tủy', 1000000, 1, 29, '', 0, 0, '', 0, ''),
            array(122, '', 'Ghép xương, ghép màng', 3000000, 1, 28, '', 0, 0, '', 0, ''),
            array(123, '', 'Răng Cercon HT', 9200000, 1, 20, '', 0, 0, '', 0, '')
        );
        foreach ($data as $key => $value) {
            $infoArr = array_values($value);
            $model = new TreatmentTypes();
            $model->id = $infoArr[0];
            $model->name = isset($infoArr[2]) ? $infoArr[2] : '';
            $model->description = $model->name;
            $model->price = isset($infoArr[3]) ? $infoArr[3] : 0;
            $model->material_price = isset($infoArr[7]) ? $infoArr[7] : 0;
            $model->labo_price = isset($infoArr[8]) ? $infoArr[8] : 0;
            $model->group_id = isset($infoArr[5]) ? $infoArr[5] : 37;
            $model->save();
        }
    }
}
