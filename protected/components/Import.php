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
            "10" => "Lạng Sơn ",
            "11" => "Bắc Kạn",
            "12" => "Thái Nguyên",
            "13" => "Yên Bái",
            "14" => "Sơn La ",
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
            "28" => "Thanh Hoá",
            "29" => "Nghệ An",
            "30" => "Hà Tĩnh",
            "31" => "Quảng Bình",
            "32" => "Quảng Trị",
            "33" => "Thừa Thiên-Huế",
            "34" => "Quảng Nam",
            "35" => "Quảng Ngãi",
            "36" => "Kontum",
            "37" => "Bình Định",
            "38" => "Gia Lai",
            "39" => "Phú Yên",
            "40" => "Đăk Lăk",
            "41" => "Khánh Hoà",
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
            "TP HCM" => array(
                "Quận 1+1" => array(
                    "Phường Tân Định",
                    "Phường Đa Kao",
                    "Phường Bến Nghé",
                    "Phường Bến Thành",
                    "Phường Nguyễn Thái Bình",
                    "Phường Phạm Ngũ Lão",
                    "Phường Cầu Ông Lãnh",
                    "Phường Cô Giang",
                    "Phường Nguyễn Cư Trinh",
                    "Phường Cầu Kho"
                ),
                "Quận 2+2" => array(
                    "Phường Thảo Điền",
                    "Phường An Phú",
                    "Phường Bình An",
                    "Phường Bình Trưng Đông",
                    "Phường Bình Trưng Tây",
                    "Phường Bình Khánh",
                    "Phường An Khánh",
                    "Phường Cát Lái",
                    "Phường Thạnh Mỹ Lợi",
                    "Phường An Lợi Đông",
                    "Phường Thủ Thiêm"
                ),
                "Quận 3+3" => array(
                    "Phường 08",
                    "Phường 07",
                    "Phường 14",
                    "Phường 12",
                    "Phường 11",
                    "Phường 13",
                    "Phường 06",
                    "Phường 09",
                    "Phường 10",
                    "Phường 04",
                    "Phường 05",
                    "Phường 03",
                    "Phường 02",
                    "Phường 01"
                ),
                "Quận 4+4" => array(
                    "Phường 12",
                    "Phường 13",
                    "Phường 09",
                    "Phường 06",
                    "Phường 08",
                    "Phường 10",
                    "Phường 05",
                    "Phường 18",
                    "Phường 14",
                    "Phường 04",
                    "Phường 03",
                    "Phường 16",
                    "Phường 02",
                    "Phường 15",
                    "Phường 01"
                ),
                "Quận 5+5" => array(
                    "Phường 04",
                    "Phường 09",
                    "Phường 03",
                    "Phường 12",
                    "Phường 02",
                    "Phường 08",
                    "Phường 15",
                    "Phường 07",
                    "Phường 01",
                    "Phường 11",
                    "Phường 14",
                    "Phường 05",
                    "Phường 06",
                    "Phường 10",
                    "Phường 13"
                ),
                "Quận 6+6" => array(
                    "Phường 14",
                    "Phường 13",
                    "Phường 09",
                    "Phường 06",
                    "Phường 12",
                    "Phường 05",
                    "Phường 11",
                    "Phường 02",
                    "Phường 01",
                    "Phường 04",
                    "Phường 08",
                    "Phường 03",
                    "Phường 07"
                ),
                "Quận 7+7" => array(
                    "Phường Tân Thuận Đông",
                    "Phường Tân Thuận Tây",
                    "Phường Tân Kiểng",
                    "Phường Tân Hưng",
                    "Phường Bình Thuận",
                    "Phường Tân Quy",
                    "Phường Phú Thuận",
                    "Phường Tân Phú",
                    "Phường Tân Phong",
                    "Phường Phú Mỹ"
                ),
                "Quận 8+8" => array(
                    "Phường 08",
                    "Phường 02",
                    "Phường 01",
                    "Phường 03",
                    "Phường 11",
                    "Phường 09",
                    "Phường 10",
                    "Phường 04",
                    "Phường 13",
                    "Phường 12",
                    "Phường 05",
                    "Phường 14",
                    "Phường 06",
                    "Phường 15",
                    "Phường 16",
                    "Phường 07"
                ),
                "Quận 9+9" => array(
                    "Phường Long Bình",
                    "Phường Long Thạnh Mỹ",
                    "Phường Tân Phú",
                    "Phường Hiệp Phú",
                    "Phường Tăng Nhơn Phú A",
                    "Phường Tăng Nhơn Phú B",
                    "Phường Phước Long B",
                    "Phường Phước Long A",
                    "Phường Trường Thạnh",
                    "Phường Long Phước",
                    "Phường Long Trường",
                    "Phường Phước Bình",
                    "Phường Phú Hữu"
                ),
                "Quận 10+10" => array(
                    "Phường 15",
                    "Phường 13",
                    "Phường 14",
                    "Phường 12",
                    "Phường 11",
                    "Phường 10",
                    "Phường 09",
                    "Phường 01",
                    "Phường 08",
                    "Phường 02",
                    "Phường 04",
                    "Phường 07",
                    "Phường 05",
                    "Phường 06",
                    "Phường 03"
                ),
                "Quận 11+11" => array(
                    "Phường 15",
                    "Phường 05",
                    "Phường 14",
                    "Phường 11",
                    "Phường 03",
                    "Phường 10",
                    "Phường 13",
                    "Phường 08",
                    "Phường 09",
                    "Phường 12",
                    "Phường 07",
                    "Phường 06",
                    "Phường 04",
                    "Phường 01",
                    "Phường 02",
                    "Phường 16"
                ),
                "Quận 12+12" => array(
                    "Phường Thạnh Xuân",
                    "Phường Thạnh Lộc",
                    "Phường Hiệp Thành",
                    "Phường Thới An",
                    "Phường Tân Chánh Hiệp",
                    "Phường An Phú Đông",
                    "Phường Tân Thới Hiệp",
                    "Phường Trung Mỹ Tây",
                    "Phường Tân Hưng Thuận",
                    "Phường Đông Hưng Thuận",
                    "Phường Tân Thới Nhất"
                ),
                "Quận Gò Vấp+13" => array(
		    "Phường 15",
		    "Phường 13",
		    "Phường 17",
		    "Phường 06",
		    "Phường 16",
		    "Phường 12",
		    "Phường 14",
		    "Phường 10",
		    "Phường 05",
		    "Phường 07",
		    "Phường 04",
		    "Phường 01",
		    "Phường 09",
		    "Phường 08",
		    "Phường 11",
		    "Phường 03"
                ),
                "Quận Tân Bình+14" => array(
		    "Phường 02",
		    "Phường 04",
		    "Phường 12",
		    "Phường 13",
		    "Phường 01",
		    "Phường 03",
		    "Phường 11",
		    "Phường 07",
		    "Phường 05",
		    "Phường 10",
		    "Phường 06",
		    "Phường 08",
		    "Phường 09",
		    "Phường 14",
		    "Phường 15"
                ),
                "Quận Tân Phú+15" => array(
		    "Phường Tân Sơn Nhì",
		    "Phường Tây Thạnh",
		    "Phường Sơn Kỳ",
		    "Phường Tân Qúy",
		    "Phường Tân Thành",
		    "Phường Phú Thọ Hoà",
		    "Phường Phú Thạnh",
		    "Phường Phú Trung",
		    "Phường Hoà Thạnh",
		    "Phường Hiệp Tân",
		    "Phường Tân Thới Hoà"
                ),
                "Quận Bình Thạnh+16" => array(
		    "Phường 13",
		    "Phường 11",
		    "Phường 27",
		    "Phường 26",
		    "Phường 12",
		    "Phường 25",
		    "Phường 05",
		    "Phường 07",
		    "Phường 24",
		    "Phường 06",
		    "Phường 14",
		    "Phường 15",
		    "Phường 02",
		    "Phường 01",
		    "Phường 03",
		    "Phường 17",
		    "Phường 21",
		    "Phường 22",
		    "Phường 19",
		    "Phường 28"
                ),
                "Quận Phú Nhuận+17" => array(
		    "Phường 04",
		    "Phường 05",
		    "Phường 09",
		    "Phường 07",
		    "Phường 03",
		    "Phường 01",
		    "Phường 02",
		    "Phường 08",
		    "Phường 15",
		    "Phường 10",
		    "Phường 11",
		    "Phường 17",
		    "Phường 14",
		    "Phường 12",
		    "Phường 13"
                ),
                "Quận Thủ Đức+18" => array(
		    "Phường Linh Xuân",
		    "Phường Bình Chiểu",
		    "Phường Linh Trung",
		    "Phường Tam Bình",
		    "Phường Tam Phú",
		    "Phường Hiệp Bình Phước",
		    "Phường Hiệp Bình Chánh",
		    "Phường Linh Chiểu",
		    "Phường Linh Tây",
		    "Phường Linh Đông",
		    "Phường Bình Thọ",
		    "Phường Trường Thọ"
                ),
                "Quận Bình Tân+19" => array(
		    "Phường Bình Hưng Hòa",
		    "Phường Bình Hưng Hoà A",
		    "Phường Bình Hưng Hoà B",
		    "Phường Bình Trị Đông",
		    "Phường Bình Trị Đông A",
		    "Phường Bình Trị Đông B",
		    "Phường Tân Tạo",
		    "Phường Tân Tạo A",
		    "Phường An Lạc",
		    "Phường An Lạc A"
                ),
                "Huyện Bình Chánh+54" => array(
		    "Thị trấn Tân Túc",
		    "Xã Phạm Văn Hai",
		    "Xã Vĩnh Lộc A",
		    "Xã Vĩnh Lộc B",
		    "Xã Bình Lợi",
		    "Xã Lê Minh Xuân",
		    "Xã Tân Nhựt",
		    "Xã Tân Kiên",
		    "Xã Bình Hưng",
		    "Xã Phong Phú",
		    "Xã An Phú Tây",
		    "Xã Hưng Long",
		    "Xã Đa Phước",
		    "Xã Tân Quý Tây",
		    "Xã Bình Chánh",
		    "Xã Quy Đức"
                ),
                "Huyện Củ Chi+52" => array(
		    "Thị trấn Củ Chi",
		    "Xã Phú Mỹ Hưng",
		    "Xã An Phú",
		    "Xã Trung Lập Thượng",
		    "Xã An Nhơn Tây",
		    "Xã Nhuận Đức",
		    "Xã Phạm Văn Cội",
		    "Xã Phú Hòa Đông",
		    "Xã Trung Lập Hạ",
		    "Xã Trung An",
		    "Xã Phước Thạnh",
		    "Xã Phước Hiệp",
		    "Xã Tân An Hội",
		    "Xã Phước Vĩnh An",
		    "Xã Thái Mỹ",
		    "Xã Tân Thạnh Tây",
		    "Xã Hòa Phú",
		    "Xã Tân Thạnh Đông",
		    "Xã Bình Mỹ",
		    "Xã Tân Phú Trung",
		    "Xã Tân Thông Hội"
                ),
                "Huyện Hóc Môn+53" => array(
		    "Thị trấn Hóc Môn",
		    "Xã Tân Hiệp",
		    "Xã Nhị Bình",
		    "Xã Đông Thạnh",
		    "Xã Tân Thới Nhì",
		    "Xã Thới Tam Thôn",
		    "Xã Xuân Thới Sơn",
		    "Xã Tân Xuân",
		    "Xã Xuân Thới Đông",
		    "Xã Trung Chánh",
		    "Xã Xuân Thới Thượng",
		    "Xã Bà Điểm"
                ),
                "Huyện Nhà Bè+55" => array(
		    "Thị trấn Nhà Bè",
		    "Xã Phước Kiển",
		    "Xã Phước Lộc",
		    "Xã Nhơn Đức",
		    "Xã Phú Xuân",
		    "Xã Long Thới",
		    "Xã Hiệp Phước"
                ),
                "Huyện Cần Giờ+56" => array(
		    "Thị trấn Cần Thạnh",
		    "Xã Bình Khánh",
		    "Xã Tam Thôn Hiệp",
		    "Xã An Thới Đông",
		    "Xã Thạnh An",
		    "Xã Long Hòa",
		    "Xã Lý Nhơn"
                )
            ),
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
                "Thành phố Thanh Hoá" => array(

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
            $cityId = Cities::getModelIdByName($cityName);
            if (!empty($cityId)) {
                foreach ($districtData as $districtName => $wardData) {
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
                        foreach ($wardData as $wardName) {
                            $ward = new Wards();
                            $ward->district_id = $model->id;
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
            array(1, '8:00'),
            array(2, '8:15'),
            array(3, '8:30'),
            array(4, '8:45'),
            array(5, '9:00'),
            array(6, '9:15'),
            array(7, '9:30'),
            array(8, '9:45'),
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
            array(57, '22:00')
        );
        
        foreach ($data as $value) {
            $infoArr = array_values($value);
            $time = new ScheduleTimes();
            $time->id = $infoArr[0];
            $time->name = $infoArr[1];
            $time->save();
        }
    }
}
