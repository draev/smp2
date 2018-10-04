<?php $running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description; ?>
<div class="content-w">
  <div class="os-tabs-w menu-shad">
		<div class="os-tabs-controls">
		  <ul class="nav nav-tabs upper">
			<li class="nav-item">
			  <a class="nav-link" href="<?php echo base_url();?>teacher/manage_attendance/"><i class="os-icon picons-thin-icon-thin-0729_student_degree_science_university_school_graduate"></i><span><?php echo get_phrase('students');?></span></a>
			</li>
<!--			<li class="nav-item">-->
<!--			  <a class="nav-link" href="--><?php //echo base_url();?><!--admin/teacher_attendance/"><i class="os-icon picons-thin-icon-thin-0704_users_profile_group_couple_man_woman"></i><span>--><?php //echo get_phrase('teachers');?><!--</span></a>-->
<!--			</li>-->
			<li class="nav-item">
			  <a class="nav-link active" href="<?php echo base_url();?>teacher/attendance_report/"><i class="os-icon picons-thin-icon-thin-0386_graph_line_chart_statistics"></i><span><?php echo get_phrase('student_attendance_report');?></span></a>
			</li>
<!--			<li class="nav-item">-->
<!--			  <a class="nav-link" href="--><?php //echo base_url();?><!--admin/teacher_attendance_report/"><i class="os-icon picons-thin-icon-thin-0386_graph_line_chart_statistics"></i><span>--><?php //echo get_phrase('teacher_attendance_report');?><!--</span></a>-->
<!--			</li>-->
		  </ul>
		</div>
	  </div>
  <div class="content-i">
    <div class="content-box">
	   <div class="element-wrapper">
          <?php echo form_open(base_url() . 'teacher/attendance_report_selector/', array('class' => 'form m-b')); ?>
              <div class="row">
                <div class="col-sm-3">
                  <div class="form-group"> 
                  <label class="gi" for=""><?php echo get_phrase('class');?>:</label> 
                    <select class="form-control" onchange="get_sections(this.value)" required="" name="class_id">
                      <option value=""><?php echo get_phrase('select');?></option>	
                      <?php 
                      $class = $this->db->get('class')->result_array();
                      foreach ($class as $row): ?>
                        <option value="<?php echo $row['class_id']; ?>" ><?php echo $row['name']; ?></option>
                      <?php endforeach; ?>
                    </select> 
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group"> 
                    <label class="gi" for=""><?php echo get_phrase('section');?>:</label> 
                      <select class="form-control" name="section_id" required="" id="section_holder">	
                        <option value=""><?php echo get_phrase('select');?></option>	
                      </select> 
                  </div>
                </div>
                  <div class="col-sm-3">
                      <div class="form-group">
                          <label class="gi" for=""><?php echo get_phrase('subject');?>:</label>
                          <select class="form-control" name="subject_id" required="" id="subject_holder">
                              <option value=""><?php echo get_phrase('select');?></option>
                          </select>
                      </div>
                  </div>
                <div class="col-sm-2">
                  <div class="form-group"> <label class="gi" for=""><?php echo get_phrase('month');?>:</label> 
                    <select name="month" class="form-control" id="month" onchange="show_year()">
            <?php
            for ($i = 1; $i <= 12; $i++):
                if ($i == 1)
                    $m = get_phrase('january');
                else if ($i == 2)
                    $m = get_phrase('february');
                else if ($i == 3)
                    $m = get_phrase('march');
                else if ($i == 4)
                    $m = get_phrase('april');
                else if ($i == 5)
                    $m = get_phrase('may');
                else if ($i == 6)
                    $m = get_phrase('june');
                else if ($i == 7)
                    $m = get_phrase('july');
                else if ($i == 8)
                    $m = get_phrase('august');
                else if ($i == 9)
                    $m = get_phrase('september');
                else if ($i == 10)
                    $m = get_phrase('october');
                else if ($i == 11)
                    $m = get_phrase('november');
                else if ($i == 12)
                    $m = get_phrase('december');
                ?>
                <option value="<?php echo $i; ?>"
                      <?php if($month == $i) echo 'selected'; ?>  >
                            <?php echo $m; ?>
                </option>
                <?php
            endfor;
            ?>
        </select>
                  </div>
                </div>
            <div class="col-md-2">
              <div class="form-group">
                <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('year'); ?></label>
                  <select class="form-control" name="year">
                    <?php
                      $year_options = explode('-', $running_year); ?>
                      <option value="<?php echo $year_options[1]; ?>"><?php echo $year_options[1]; ?></option>
                      <option value="<?php echo $year_options[0]; ?>"><?php echo $year_options[0]; ?></option>
                    </select>
                </div>
              </div>
                <div class="col-sm-2">
                  <div class="form-group"> <button class="btn btn-primary btn-rounded btn-upper" style="margin-top:20px" type="submit"><span><?php echo get_phrase('generate');?></span></button></div>
                </div>
              </div>
              <input type="hidden" name="operation" value="selection">
            <?php echo form_close();?>
          </div>
        </div>
      </div>
    </div>


    <script type="text/javascript">
       function get_sections(class_id) 
   {
      $.ajax({
            url: '<?php echo base_url();?>admin/get_class_section/' + class_id ,
            success: function(response)
            {
                jQuery('#section_holder').html(response);
            }
        });

       $.ajax({
           url: '<?php echo base_url(); ?>admin/get_class_subject/' + class_id,
           success:function (response)
           {
               jQuery('#subject_holder').html(response);
           }
       });
   }
    </script>
