<?php

namespace App\Traits;

use App\Models\Certificate;
use PDF;

trait GenerateCertificate
{
    public function generateOldPdf($name, $email, $course_name, $date)
    {
        $file_name = $name . ' - ' . $course_name;
        $pdfDestinationPath = public_path('/pdfs/old-certificates/' . strtolower($email). '/');

        // $file_name = $email . ' - ' .$name . ' - ' . $course_name;
        // $pdfDestinationPath = public_path('/pdfs/old-certificates/');

        if (!file_exists($pdfDestinationPath)) {
            mkdir($pdfDestinationPath, 0777, true);
        }

        $pdf_file = $file_name . ".pdf";
        $pdfFilePath = $pdfDestinationPath . $pdf_file;

        if (file_exists($pdfFilePath)) {
            unlink($pdfFilePath);
        }

        $data = getimagesize(public_path('images/blank-certificate.jpg'));
        $width = $data[0];
        $height = $data[1];

        $hasAwarded = [
            '8 Hour Initial Administrator Training' => '8 clock hours',

            'Texas Administrators 8 Hour' => '8 clock hours',
            'Texas Administrators 8' => '8 clock hours',

            'Texas Administrators 12 Hour (Original Version)' => '12 clock hours',
            'Texas Administrators 12 (Original Version)' => '12 clock hours',
            'Texas Administrators 12 (Original Version)' => '12 clock hours',

            'Texas Administrators 16 Hour' => '16 clock hours',
            'Texas Administrators 16' => '16 clock hours',

            '12 Hour CE Administrator Training (Original Version)' => '12 clock hours',

            '12 Hour Texas HCSSA Package for Administrators in Primary Home Care' => '', // check content
            '12-Hour Texas HCSSA Package for Administrators in Home Health' => '',
            '12-Hour Texas HCSSA Package for Administrators in Primary Home Care' => '',
            '12-Hour Texas HCSSA Package for Administrators in Hospice' => '',
            '12 Hour Texas HCSSA Package for Administrators in Home Health' => '',

            '16 Hour Initial Administrator Training' => '',

            'How Successful Primary Home Care Agencies Market to Community Sources &amp; Assisted Living Facilities' => '6 Training Hours',
            'How Successful Hospices Market to Medicals and Assisted Living Facilities' => '',

            'Oklahoma 6-Hour Administrator CEUs' => '6 Training Hours',
            'Oklahoma 6 Hour Administrator CEUs' => '6 Training Hours'
        ];

        $description = [
            '8 Hour Initial Administrator Training' => '<p>Meets 26 TAC 558.259(c): In-depth course covering HCSSA Licensing Standards including subchapters A-G,<br />Texas Health and Safety Code, Chapter 142, Chapter 250, Nurse Aide Registry and Criminal History Checks of Employees and Applicants for<br />Employment in Certain Facilities Serving the Elderly or Persons with Disabilities; Texas Human Resources Code, Chapter 102,<br />Rights of the Elderly; Americans with Disabilities Act; Civil Rights Act of 1991; Rehabilitation Act of 1993;<br />Family and Medical Leave Act of 1993; and the Occupational Safety and Health Administration requirements.</p>',

            'Texas Administrators 8 Hour' => '<p>Meets 26 TAC 558.259(c): In-depth course covering HCSSA Licensing Standards including subchapters A-G,<br />Texas Health and Safety Code, Chapter 142, Chapter 250, Nurse Aide Registry and Criminal History Checks of Employees and Applicants for<br />Employment in Certain Facilities Serving the Elderly or Persons with Disabilities; Texas Human Resources Code, Chapter 102,<br />Rights of the Elderly; Americans with Disabilities Act; Civil Rights Act of 1991; Rehabilitation Act of 1993;<br />Family and Medical Leave Act of 1993; and the Occupational Safety and Health Administration requirements.</p>',
            'Texas Administrators 8' => '<p>Meets 26 TAC 558.259(c): In-depth course covering HCSSA Licensing Standards including subchapters A-G,<br />Texas Health and Safety Code, Chapter 142, Chapter 250, Nurse Aide Registry and Criminal History Checks of Employees and Applicants for<br />Employment in Certain Facilities Serving the Elderly or Persons with Disabilities; Texas Human Resources Code, Chapter 102,<br />Rights of the Elderly; Americans with Disabilities Act; Civil Rights Act of 1991; Rehabilitation Act of 1993;<br />Family and Medical Leave Act of 1993; and the Occupational Safety and Health Administration requirements.</p>',

            'Texas Administrators 12 Hour (Original Version)' => '<p>Meets 26 TAC 558.260(a): In-depth course covering definitions and treatment of Ethics, Human Resources, Development and<br />Interpretation of Policies and Procedures, Fraud and Abuse, and Marketing. Student learned how to find, interview, perform <br />background checks on the caregiver. Student learned how to train, motivate, discipline caregivers. Student learned the importance <br />of Ethics in healthcare. Student learned guidelines for writing good policies and procedures. Student understood the most effective<br /> ways to assure policy implementation. Student learned how to market their agency ethically and legally. Student learned effective<br /> methods of marketing.</p>',
            'Texas Administrators 12 (Original Version)' => '<p>Meets 26 TAC 558.260(a): In-depth course covering definitions and treatment of Ethics, Human Resources, Development and<br />Interpretation of Policies and Procedures, Fraud and Abuse, and Marketing. Student learned how to find, interview, perform <br />background checks on the caregiver. Student learned how to train, motivate, discipline caregivers. Student learned the importance <br />of Ethics in healthcare. Student learned guidelines for writing good policies and procedures. Student understood the most effective<br /> ways to assure policy implementation. Student learned how to market their agency ethically and legally. Student learned effective<br /> methods of marketing.</p>',
            'Texas Administrators 12 (Original Version)' => '<p>Meets 26 TAC 558.260(a): In-depth course covering definitions and treatment of Ethics, Human Resources, Development and<br />Interpretation of Policies and Procedures, Fraud and Abuse, and Marketing. Student learned how to find, interview, perform <br />background checks on the caregiver. Student learned how to train, motivate, discipline caregivers. Student learned the importance <br />of Ethics in healthcare. Student learned guidelines for writing good policies and procedures. Student understood the most effective<br /> ways to assure policy implementation. Student learned how to market their agency ethically and legally. Student learned effective<br /> methods of marketing.</p>',

            'Texas Administrators 16 Hour' => '<p>Meets HHSCA 26 TAC 558.259(D)(1)-(10): In-Depth course detailing: Fraud and abuse detection and prevention;<br />legal issues regarding advance directives; client rights, including the right to confidentiaity; agency responsibilities; complaint investigation and resolution;<br />emergency preparedness planning and implementation; abuse, neglect, and exploitation; infection control;<br />"Outcome and Assessment Information Set" (OASIS); face-to-face encounters. </p>',
            'Texas Administrators 16' => '<p>Meets HHSCA 26 TAC 558.259(D)(1)-(10): In-Depth course detailing: Fraud and abuse detection and prevention;<br />legal issues regarding advance directives; client rights, including the right to confidentiaity; agency responsibilities; complaint investigation and resolution;<br />emergency preparedness planning and implementation; abuse, neglect, and exploitation; infection control;<br />"Outcome and Assessment Information Set" (OASIS); face-to-face encounters. </p>',

            '12 Hour CE Administrator Training (Original Version)' => '<p>Meets 26 TAC 558.260(a): In-depth course covering definitions and treatment of Ethics, Human Resources, Development and<br />Interpretation of Policies and Procedures, Fraud and Abuse, and Marketing. Student learned how to find, interview, perform<br />background checks on the caregiver. Student learned how to train, motivate, discipline caregivers. Student learned the importance<br />of Ethics in healthcare. Student learned guidelines for writing good policies and procedures. Student understood the most effective<br />ways to assure policy implementation. Student learned how to market their agency ethically and legally. Student learned effective<br />methods of marketing.</p>',

            '12 Hour Texas HCSSA Package for Administrators in Primary Home Care' => '<p>Meets 26 TAC 558.260(a): In-depth course covering definitions and treatment of Ethics, Human Resources, Development and<br />Interpretation of Policies and Procedures, Fraud and Abuse, and Marketing. Student learned how to find, interview, perform<br />background checks on the caregiver. Student learned how to train, motivate, discipline caregivers. Student learned the importance<br />of Ethics in healthcare. Student learned guidelines for writing good policies and procedures. Student understood the most effective<br />ways to assure policy implementation. Student learned how to market their agency ethically and legally. Student learned effective<br />methods of marketing.</p>',
            '12-Hour Texas HCSSA Package for Administrators in Home Health' => '<p>Meets 26 TAC 558.260(a): In-depth course covering definitions and treatment of Ethics, Human Resources, Development and<br />Interpretation of Policies and Procedures, Fraud and Abuse, and Marketing. Student learned how to find, interview, perform<br />background checks on the caregiver. Student learned how to train, motivate, discipline caregivers. Student learned the importance<br />of Ethics in healthcare. Student learned guidelines for writing good policies and procedures. Student understood the most effective<br />ways to assure policy implementation. Student learned how to market their agency ethically and legally. Student learned effective<br />methods of marketing.</p>',
            '12-Hour Texas HCSSA Package for Administrators in Primary Home Care' => '<p>Meets 26 TAC 558.260(a): In-depth course covering definitions and treatment of Ethics, Human Resources, Development and<br />Interpretation of Policies and Procedures, Fraud and Abuse, and Marketing. Student learned how to find, interview, perform<br />background checks on the caregiver. Student learned how to train, motivate, discipline caregivers. Student learned the importance<br />of Ethics in healthcare. Student learned guidelines for writing good policies and procedures. Student understood the most effective<br />ways to assure policy implementation. Student learned how to market their agency ethically and legally. Student learned effective<br />methods of marketing.</p>',
            '12-Hour Texas HCSSA Package for Administrators in Hospice' => '<p>Meets 26 TAC 558.260(a): In-depth course covering definitions and treatment of Ethics, Human Resources, Development and<br />Interpretation of Policies and Procedures, Fraud and Abuse, and Marketing. Student learned how to find, interview, perform<br />background checks on the caregiver. Student learned how to train, motivate, discipline caregivers. Student learned the importance<br />of Ethics in healthcare. Student learned guidelines for writing good policies and procedures. Student understood the most effective<br />ways to assure policy implementation. Student learned how to market their agency ethically and legally. Student learned effective<br />methods of marketing.</p>',
            '12 Hour Texas HCSSA Package for Administrators in Home Health' => '<p>Meets 26 TAC 558.260(a): In-depth course covering definitions and treatment of Ethics, Human Resources, Development and<br />Interpretation of Policies and Procedures, Fraud and Abuse, and Marketing. Student learned how to find, interview, perform<br />background checks on the caregiver. Student learned how to train, motivate, discipline caregivers. Student learned the importance<br />of Ethics in healthcare. Student learned guidelines for writing good policies and procedures. Student understood the most effective<br />ways to assure policy implementation. Student learned how to market their agency ethically and legally. Student learned effective<br />methods of marketing.</p>',

            '16 Hour Initial Administrator Training' => '<p>Meets HHSCA 26 TAC 558.259(D)(1)-(10): In-Depth course detailing: Fraud and abuse detection and prevention;<br />legal issues regarding advance directives; client rights, including the right to confidentiaity; agency responsibilities; complaint investigation and resolution;<br />emergency preparedness planning and implementation; abuse, neglect, and exploitation; infection control;<br />"Outcome and Assessment Information Set" (OASIS); face-to-face encounters. </p>',

            'How Successful Primary Home Care Agencies Market to Community Sources &amp; Assisted Living Facilities' => '<p>Through completion of this course, the person who earned this certificate received 6 hours of training in the following subjects:<br />Administrative skills, duties, and responsibilities; Administrative procedures and strategic planning; Community relations and public information;<br />Ethical decision-making and management</p>',
            'How Successful Hospices Market to Medicals and Assisted Living Facilities' => '<p>Through completion of this course, the person who earned this certificate received 6 hours of training in the following subjects:<br />Administrative skills, duties, and responsibilities; Administrative procedures and strategic planning; Community relations and public information;<br />Ethical decision-making and management</p>',

            'Oklahoma 6-Hour Administrator CEUs' => '<p>Through completion of this course, the person who earned this certificate received 6 hours of training in the following subjects:<br />Administrative skills, duties, and responsibilities; Administrative procedures and strategic planning; Community relations and public information;<br />Ethical decision-making and management</p>',
            'Oklahoma 6 Hour Administrator CEUs' => '<p>Through completion of this course, the person who earned this certificate received 6 hours of training in the following subjects:<br />Administrative skills, duties, and responsibilities; Administrative procedures and strategic planning; Community relations and public information;<br />Ethical decision-making and management</p>'
        ];

        $certificate = (object) [
            'name' => $name,
            'line1' => 'Has successfully completed the course',
            'line2' => 'And has been awarded ' . $hasAwarded[$course_name],
            'description' => $description[$course_name],
            'image' => 'blank-certificate.jpg'
        ];

        $pdf = PDF::loadView('pdf.certificate', compact('certificate', 'name', 'course_name', 'date'))->setPaper([0, 0, 686, 885], 'landscape');
        $pdf->save($pdfFilePath);

        return [
            'preview_pdf' => $pdf_file
        ];
    }

    public function generatePdf($certificate, $name, $course_name, $date)
    {
        $file_name = "Certificate-Preview-" . time();
        $pdfDestinationPath = public_path('/pdfs/certificates/');

        if (!file_exists($pdfDestinationPath)) {
            mkdir($pdfDestinationPath, 0777, true);
        }

        $pdf_file = $file_name . ".pdf";
        $pdfFilePath = $pdfDestinationPath . $pdf_file;

        if (file_exists($pdfFilePath)) {
            unlink($pdfFilePath);
        }

        $data = getimagesize(public_path('images/certificate/' . $certificate->image));
        $width = $data[0];
        $height = $data[1];

        $pdf = PDF::loadView('pdf.certificate', compact('certificate', 'name', 'course_name', 'date'))->setPaper([0, 0, 686, 885], 'landscape');
        $pdf->save($pdfFilePath);

        return [
            'preview_pdf' => $pdf_file
        ];
    }

    public function generateCertificatePreview($certificate, $name, $course_name, $date)
    {
        $image_path = public_path('images/certificate/' . $certificate->image);
        $image_details = getimagesize($image_path);
        switch (strtolower($image_details['mime'])) {
            case 'image/png':
                $image = imagecreatefrompng($image_path);
                break;
            case 'image/jpeg':
                $image = imagecreatefromjpeg($image_path);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($image_path);
                break;
            default:
                return null;
        }

        $course_title = $course_name;
        $description = wordwrap(strip_tags($certificate->description), 130, "\n");
        $line1 = $certificate->line1;
        $line2 = $certificate->line2;
        $date = "Certificate granted : " . date('F d, Y', strtotime($date));

        $text_font = public_path('front/fonts/certificate/TimesNewRoman.ttf');
        $extra_large_font_size = 60;
        $large_font_size = 40;
        $regular_font_size = 25;

        $image_height = imagesy($image);
        $image_width = imagesx($image);

        $text_box = imagettfbbox($extra_large_font_size, 0, $text_font, $name);

        $name_box_width = $text_box[2] - $text_box[0];
        $name_box_height = $text_box[7] - $text_box[1];
        $name_box_x = ($image_width / 2) - ($name_box_width / 2);
        $name_box_y = ($image_height / 2) - ($name_box_height / 2) - 390;

        $line1_box = imagettfbbox($regular_font_size + 5, 0, $text_font, $line1);
        $line1_box_width = $line1_box[2] - $line1_box[0];
        $line1_box_x = ($image_width / 2) - ($line1_box_width / 2);
        $line1_box_y = $name_box_y + 90;

        $course_title_box = imagettfbbox($large_font_size, 0, $text_font, $course_title);
        $course_title_box_width = $course_title_box[2] - $course_title_box[0];
        $course_title_box_x = ($image_width / 2) - ($course_title_box_width / 2);
        $course_title_box_y = $line1_box_y + 90;

        $line2_box = imagettfbbox($regular_font_size + 5, 0, $text_font, $line2);
        $line2_box_width = $line2_box[2] - $line2_box[0];
        $line2_box_x = ($image_width / 2) - ($line2_box_width / 2);
        $line2_box_y = $course_title_box_y + 90;

        $description_text_box = imagettfbbox($regular_font_size, 0, $text_font, $description);
        $description_text_box_width = ($description_text_box[2] - $description_text_box[0]) + 180;
        $description_text_box_x = ($image_width / 2) - ($description_text_box_width / 2);
        $description_text_box_y = $line2_box_y + 90;

        $date_box = imagettfbbox($regular_font_size, 0, $text_font, $date);
        $date_box_width = $date_box[2] - $date_box[0];
        $date_box_x = ($image_width / 2) - ($date_box_width / 2);
        $date_box_y = $description_text_box_y + 360;

        $color = imagecolorallocate($image, 0, 0, 0);

        imagettftext($image, $regular_font_size + 5, 0, $date_box_x - 50, $date_box_y, $color, $text_font, $date);
        imagettftext($image, $extra_large_font_size, 0, $name_box_x, $name_box_y, $color, $text_font, $name);
        imagettftext($image, $regular_font_size + 5, 0, $line1_box_x, $line1_box_y, $color, $text_font, $line1);
        imagettftext($image, $large_font_size, 0, $course_title_box_x, $course_title_box_y, $color, $text_font, $course_title);
        imagettftext($image, $regular_font_size + 5, 0, $line2_box_x, $line2_box_y, $color, $text_font, $line2);
        $this->imagettftextcenter($image, $regular_font_size, $description_text_box_x, $description_text_box_y, $color, $text_font, $description);

        $file_name = "Certificate-Preview-" . $certificate->id;
        $imageDestinationPath = public_path('/images/certificates/');
        if (!file_exists($imageDestinationPath)) {
            mkdir($imageDestinationPath, 0777, true);
        }

        $image_file = $file_name . ".jpg";
        $imageFilePath = $imageDestinationPath . $image_file;

        if (file_exists($imageFilePath)) {
            unlink($imageFilePath);
        }

        imagejpeg($image, $imageFilePath);
        imagedestroy($image);

        $pdfDestinationPath = public_path('/pdfs/certificates/');

        if (!file_exists($pdfDestinationPath)) {
            mkdir($pdfDestinationPath, 0777, true);
        }

        $pdf_file = $file_name . ".pdf";
        $pdfFilePath = $pdfDestinationPath . $pdf_file;

        if (file_exists($pdfFilePath)) {
            unlink($pdfFilePath);
        }

        $pdf = PDF::loadView('pdf.certificate', compact('image_file'))->setPaper('a4', 'landscape');
        $pdf->save($pdfFilePath);

        Certificate::where('id', $certificate->id)->update([
            'preview_pdf' => $pdf_file
        ]);

        return [
            'preview_pdf' => $pdf_file
        ];
    }

    public function imagettftextcenter($image, $size, $x, $y, $color, $fontfile, $text)
    {
        $rect = imagettfbbox($size, 0, $fontfile, "Tq");
        $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $h1 = $maxY - $minY;

        $rect = imagettfbbox($size, 0, $fontfile, "Tq\nTq");
        $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $h2 = $maxY - $minY;

        $vpadding = $h2 - $h1 - $h1;

        $frect = imagettfbbox($size, 0, $fontfile, $text);
        $minX = min(array($frect[0], $frect[2], $frect[4], $frect[6]));
        $maxX = max(array($frect[0], $frect[2], $frect[4], $frect[6]));
        $text_width = $maxX - $minX;

        $text = explode("\n", $text);
        foreach ($text as $txt) {
            $rect = imagettfbbox($size, 0, $fontfile, $txt);
            $minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
            $maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
            $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
            $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));

            $width = $maxX - $minX;
            $height = $maxY - $minY;

            $_x = $x + (($text_width - $width) / 2);

            imagettftext($image, $size + 2.5 , 0, $_x, $y, $color, $fontfile, $txt);
            $y += ($height + $vpadding);
        }

        return $rect;
    }
}
