<?php
session_start();
//驗證碼長度
$cert = 4;
$code = [];
while (count($code) < 4) {
    $type = rand(1, 2);
    switch ($type) {
        case 1:
            //英文大寫
            $str = chr(rand(65, 90));
            if (!in_array($str, $code)) {
                $code[] = $str;
            }
            break;
        case 2:
            //數字
            $str = chr(rand(48, 57));
            if (!in_array($str, $code)) {
                $code[] = $str;
            }
            break;
    }
}

//把驗證碼答案存作session
$_SESSION['ans']=join("",$code);

$fontBox = []; //宣告一個空陣列來存放每一個字元的資訊
$font_w = 0; //宣告一個變數來紀錄文字圖片的寬度
$font_h = 0; //宣告一個變數來紀錄文字圖片的高度

//使用迴圈及imagettfbbox來取得每一個字串的四個點坐標資訊
for ($i = 0; $i < $cert; $i++) {

    //取出單一字元
    $s = $code[$i];

    //取得單一字元的四角坐標資訊
    $tmp = imagettfbbox(30, 0, realpath('arial.ttf'), $s);

    //把四個x點的坐標及四個y點的坐標分別放入兩個陣列中
    $x = [$tmp[0], $tmp[2], $tmp[4], $tmp[6]];
    $y = [$tmp[1], $tmp[3], $tmp[5], $tmp[7]];

    //利用一個陣列來存放每個字元的字型資訊,包括長寬及最大最小x,y值
    //1.計算單一字元的長寬並存入該字元代表的陣列中
    $fontBox[$s]['width'] = max($x) - min($x);
    $fontBox[$s]['height'] = max($y) - min($y);

    //將計算出來的寬隨著迴圈累加上去
    $font_w += $fontBox[$s]['width'];

    //2.將x,y的最大最小值也存入陣列中,用來計算最後要畫的位置
    $fontBox[$s]['max_x'] = max($x);
    $fontBox[$s]['min_x'] = min($x);
    $fontBox[$s]['max_y'] = max($y);
    $fontBox[$s]['min_y'] = min($y);

}

//利用迴圈和前面計算及準備的各項資訊，實際寫入到圖形資源中
for ($i = 0; $i < $cert; $i++) {
//建立一個全彩的圖形資源
    $dstimg = imagecreatetruecolor(40, 40);
    //建立一個圖形資源當成底圖的邊框
    $bg = imagecreatetruecolor(42, 42);

    //建立彩色圖形資源，這裏建立的是白色和黑色
    $white = imagecolorallocate($dstimg, 255, 255, 255);
    $black = imagecolorallocate($dstimg, 0, 0, 0);

    //將底色先填入底圖中
    imagefill($dstimg, 0, 0, $white);
    imagefill($bg, 0, 0, $black);
    //取出單一字元
    $s = $code[$i];

    //計算每個字元實際寫入的坐標點，依據每個字元取得最大最小值來判斷
    $start_x = (40 - $fontBox[$s]['width']) / 2 - $fontBox[$s]['min_x'];

    //在預定繪製的y坐標加上高度差
    $start_y = (40 - $fontBox[$s]['height']) / 2 - $fontBox[$s]['min_y'];
    //依照上面計算的結果將參數放入imagettftext函式中，並寫入底圖中
    imagettftext($dstimg, 30, 0, $start_x, $start_y, $black, realpath('arial.ttf'), $s);

    //將底圖寫入邊框
    imagecopyresampled($bg, $dstimg, 1, 1, 0, 0, 40, 40, 40, 40);

    //將圖形資源輸出成為base64字串

    ob_start();
    imagepng($bg);
    $base64 = ob_get_clean();
    $captcha[$s] = "data:image/png;base64," . base64_encode($base64);
}

//圖片陣列依照KEY值做排序，製造和答案不同的排列
ksort($captcha, SORT_STRING);

echo json_encode(['ans' => $code, 'captcha' => $captcha]);
