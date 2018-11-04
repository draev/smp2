<?php 
    $class_name             =     $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;
    $exam_name          =     $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name;
    $system_name        =    $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
    $running_year       =    $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
?>
<div id="print">
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <style type="text/css">
        td {
            padding: 5px;
        }
    </style>

    <center>
        <img src="<?php echo base_url();?>uploads/logo.png" style="max-height : 60px;"><br>
        <h3 style="font-weight: 100;"><?php echo $system_name;?></h3>
        <?php echo get_phrase('tabulation_sheet');?><br>
        <?php echo get_phrase('class') . ' ' . $class_name;?><br>
        <?php echo $exam_name;?>
    </center>

    <table style="width:100%; border-collapse:collapse;border: 1px solid #ccc; margin-top: 10px;" border="1">
        <thead>
            <tr>
            <td style="text-align: center;">
                <?php echo get_phrase('students');?> <i class="fa fa-arrow-circle-down"></i> | <?php echo get_phrase('subjects');?> <i class="fa fa-arrow-circle-right"></i>
            </td>
            <?php 
                $subjects = $this->db->get_where('subject' , array('class_id' => $class_id , 'year' => $running_year))->result_array();
                foreach($subjects as $row):
            ?>
                <td style="text-align: center;"><?php echo $row['name'];?></td>
            <?php endforeach;?>
            <td style="text-align: center;"><?php echo get_phrase('average');?></td>
            </tr>
        </thead>
        <tbody>
        <?php
        $students = $this->db->get_where('enroll' , array('class_id' => $class_id, 'year' => $running_year))->result_array();
        foreach($students as $row):
            ?>
    
            <?php
            $properties = [
                'labuno', 'labdos', 'labtres', 'labcuatro', 'labcinco', 'labseis',
                'labsiete', 'labocho', 'labnueve'
            ];
            ?>
    
            <?php foreach ($properties as $key => $property): ?>
            <tr>
                <?php if($key === 0): ?>
                    <td nowrap rowspan="11" style="vertical-align: top">
                        <img alt="" src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" width="25px" style="border-radius: 10px;margin-right:5px;"> <?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;?>
                    </td>
                <?php endif; ?>
        
                <?php foreach($subjects as $subject): ?>
                    <td style="text-align: center; padding: 0;">
                        <?php $marks = $this->db->get_where('mark' , array('class_id' => $class_id ,'exam_id' => $exam_id ,
                                                                           'subject_id' => $subject['subject_id'] , 'student_id' => $row['student_id'],'year' => $running_year));
                        if ($marks->row()->{$property}) {
                            echo $marks->row()->{$property};
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                <?php endforeach;?>
        
                <?php if($key === 0): ?>
                    <td rowspan="10"></td>
                <?php endif;?>
            </tr>
        <?php endforeach;?>

            <tr>
                <td colspan="<?php echo count($subjects);?>" style="padding: 1px"></td>
            </tr>

            <tr>
                <?php $total_marks = 0;  foreach($subjects as $row2): ?>
                    <td style="text-align: center;">
                        <?php $marks =  $this->db->get_where('mark' , array('class_id' => $class_id ,'exam_id' => $exam_id ,
                                                                            'subject_id' => $row2['subject_id'],'student_id' => $row['student_id'],'year' => $running_year));
                        if($marks->num_rows() > 0)
                        {
                            $obtained_marks = (int)$marks->row()->labtotal;
                            echo '<b>MEDIA ' .$obtained_marks . '</b>';
                            $total_marks += $obtained_marks;
                        }
                        ?>
                    </td>
                <?php endforeach;?>

                <td class="average" style="text-align: center"><?php
                    $this->db->where('class_id' , $class_id);
                    $this->db->where('year' , $running_year);
                    $this->db->from('subject');
                    $total_subjects = $this->db->count_all_results();
                    echo 'MEDIA GENERALA ';
                    if(count($subjects)) {
                        echo number_format(($total_marks / count($subjects)));
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($)
    {
        var elem = $('#print');
        PrintElem(elem);
        Popup(data);

    });

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.focus();
        mywindow.print();
        mywindow.close();
        return true;
    }
</script>
