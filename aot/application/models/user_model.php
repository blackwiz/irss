<?php

class User_model extends CI_Model 
{
		function username_exists($username)
	    {
	        $this->db->where('username',$username);
	        $query = $this->db->get('jb_person');
	        if ($query->num_rows() > 0)
	        {
	            return true;
	        }
	        else
	        {
	            return false;
	        }
	    }

        function email_exists($email)
        {
        $this->db->where('email',$email);
        $query = $this->db->get('jb_person');
        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
        }

        function insert($table, $data=array())
        {
        	$this->db->insert($table, $data);
        	if($this->db->affected_rows() > 0)
        	{
        		return true;
        	}
        	else
        	{
        		return false;
        	}
        }
        function login($username, $password)
        {
        	$this->db->select('*');
        	$this->db->where('username', $username);
        	$this->db->where('password', $password);
        	$this->db->from('jb_person');
        	$result = $this->db->get();
        	if($result->num_rows() > 0)
        	{
                $userdetails = $result->row();
                $userdata['userdetails'] = array('user_username' =>$userdetails->username,
                                      'userid' =>$userdetails->user_id
                                     );
                $this->session->set_userdata($userdata);
        		return true;

        	}
        	else
        	{
        		return false;
        	}
        }
        
        function logintoken($id)
        {
        	$this->db->select('*');
        	$this->db->where('user_id', $id);
        	$this->db->from('jb_person');
        	$result = $this->db->get();
        	if($result->num_rows() > 0)
        	{
                $userdetails = $result->row();
                $userdata['userdetails'] = array('user_username' =>$userdetails->username,
                                      'userid' =>$userdetails->user_id
                                     );
                $this->session->set_userdata($userdata);
        		return true;

        	}
        	else
        	{
        		return false;
        	}
        }
        
        function recordexam_start($examid, $userid)
        {
            $this->db->select('*');
            $this->db->from('userexam');
            $this->db->where('userid', $userid);
            $this->db->where('examid', $examid);
            $result = $this->db->get();
            if($result->num_rows() > 0)
            {
                $this->db->where('userid', $userid);
                $this->db->where('examid', $examid);

                $this->db->delete('userexam');
                $exam_newstatus = array('userid'=>$userid, 'examid'=>$examid);
                $this->db->set('starttime', 'NOW()', FALSE);
                $this->db->insert('userexam', $exam_newstatus);
            }
            else
            {
                $exam_newstatus = array('userid'=>$userid, 'examid'=>$examid);
                $this->db->set('starttime', 'NOW()', FALSE);
                $this->db->insert('userexam', $exam_newstatus);
            }
        }
        function save_answer($useranswer, $examid, $questionid, $userid)
        {
            $this->db->select('*');
            $this->db->from('userquestions');
            $this->db->where('userid', $userid);
            $this->db->where('examid', $examid);
            $this->db->where('questionid', $questionid);
            $result = $this->db->get();
            if($result->num_rows() > 0)
            {
            $question_status = array('answered' => 'answered', 'useranswer' => $useranswer);
            $this->db->where('userid', $userid);
            $this->db->where('examid', $examid);
            $this->db->where('questionid', $questionid);
            $this->db->update('userquestions',  $question_status);
            }
            else
            {
             $question_status = array('userid' => $userid,
                                      'examid' => $examid,
                                      'questionid' => $questionid,
                                      'answered' => 'answered', 
                                      'useranswer' => $useranswer);
             $this->db->insert('userquestions', $question_status);
            }
        }

        function finish_user_exam($examid, $userid)
        {
            $exam_newstatus = array('endtime' => date('Y-m-d H:i:s'),
                                    'status' => 'completed'
                                    );
             $this->db->where('examid', $examid);
             $this->db->where('userid', $userid);
             $this->db->set('status', 'completed');
             $this->db->set('endtime', 'NOW()', FALSE);
             $this->db->update('userexam');
             
        }
        function exams($userid)
        {
            $this->db->select('*');
            $this->db->from('exam_category');
            $categories_exams = $this->db->get()->result_array();
            foreach ($categories_exams as $x => $category) 
            {
               $this->db->select("a.*, (case when date(now()) <= a.availableto AND date(now()) <= b.enddate then 1 else 0 end) as aktif",false); 
$this->db->from('exams a');
               $this->db->join('jb_aot_person b','b.exam_id = a.examid','LEFT');
               $this->db->where('a.catid', $category['catid']);
               $this->db->where('b.user_id', $userid);
               $exams = $this->db->get()->result_array();
               foreach ($exams as $count => $exam) 
               {
                   // $this->db->select('userexam.*, jb_aot_person.showstatus, SUM(questions.marks) AS maxmarks, exams.passmark');
$this->db->select('userexam.*,SUM(questions.marks) AS maxmarks, exams.passmark');                    
$this->db->from('userexam');
                    $this->db->join('exams', 'exams.examid = userexam.examid');
                    $this->db->join('questions', 'questions.examid = userexam.examid');
					$this->db->join('jb_aot_person','userexam.examid = jb_aot_person.exam_id AND userexam.userid = jb_aot_person.user_id','LEFT OUTER');
                    $this->db->where('userexam.userid', $userid);
                    $this->db->where('userexam.examid', $exam['examid']);
					$this->db->group_by(array( "userexam.userid", "userexam.examid", "userexam.starttime", "userexam.endtime", "userexam.correctlyanswered", "userexam.status", "exams.passmark")); 
                    $exam_records = $this->db->get();
                    foreach ($exam_records->result_array() as $exam) 
                    {
                    if(strlen(implode($exam)) > 0)
                    {
                        $results = array();
                        $examdata = $exam_records->row();
                        $this->db->select('userquestions.questionid, userquestions.useranswer, questions.correctanswer,questions.marks');
                        $this->db->from('userquestions');
                        $this->db->join('questions', 'questions.questionid = userquestions.questionid');
                        $this->db->where('userquestions.examid', $exam['examid']);
                        $this->db->where('userquestions.userid', $userid);
                        $allquestions = $this->db->get()->result_array();
                        $marksobtained = 0;
                        $failedquestions = array();
                        foreach ($allquestions as  $questiondata) 
                        {
                            if($questiondata['useranswer'] == $questiondata['correctanswer'])
                            {
                                $marksobtained += $questiondata['marks'];
                            }
                        }
                        if($marksobtained > 0)
                        {
                            $exams[$count]['percentage'] = floor(($marksobtained / $examdata->maxmarks) * 100);
                            if($exams[$count]['percentage'] >= $examdata->passmark)
                            {
                                $exams[$count]['passed'] = 'Passed';
                            }
                            else
                            {
                                $exams[$count]['passed'] = 'Failed';
                            }
                            //$exams[$count]['status'] = $examdata->showstatus;
                        }
                        else
                        {
                            $exams[$count]['percentage'] = 0;
                            $exams[$count]['passed'] = 'Failed';
                            //$exams[$count]['status'] = $examdata->showstatus;
                        }
                    } 
                    }                        
               }
               $categories_exams[$x]['exams'] = $exams;
            }
            return $categories_exams;
        }

        function examdetails($examid)
        {
           $this->db->select('*'); 
           $this->db->from('exams');
           $this->db->where('examid', $examid);
           $examdetails = $this->db->get()->result_array();
            return $examdetails;
        }
        function userprofile($userid)
        {
           $this->db->select('*'); 
           $this->db->from('jb_person');
           $this->db->where('user_id', $userid);
           $userdetails = $this->db->get()->row();
            return $userdetails;
        }
        function updateprofile($details, $userid, $password)
        {
            $this->db->select('*');
            $this->db->from('jb_person');
            $this->db->where('user_id', $userid);
            $this->db->where('password', sha1($password));
            $userdata = $this->db->get();
            if($userdata->num_rows() > 0)
            {
                $this->db->where('user_id', $userid);
                $this->db->update('jb_person', $details);
                return true;
            }
            else
            {
                return false;
            }
            
        }
        function update($tablename, $details, $fieldname, $fieldvalue)
        {
            $this->db->where($fieldname, $fieldvalue);
            $this->db->update($tablename, $details);
        }
        function examdata($examid)
        {
            $this->db->select('examid, examname, duration');
            $this->db->from('exams');
            $this->db->where('examid', $examid);
            $result = $this->db->get()->row();
            return $result;
        }
        function get_exam_data($examid)
        {
            $this->db->select('examid, examname, duration, questions');
            $this->db->from('exams');
            $this->db->where('examid', $examid);
            $result = $this->db->get();

            $exam = array();
            $examrow = $result->row();
            $exam['id'] = $examrow->examid;
            $exam['name'] = $examrow->examname;

            $this->db->select('*');
            $this->db->from('questions');
            $this->db->where('examid', $examid);
            $this->db->order_by('examid', 'random');
            $this->db->limit($examrow->questions);
            $result_questions = $this->db->get();

            $exam['questions'] = array();
            foreach ($result_questions->result_array() as $x => $question) 
            {
                $exam['questions'][$x]['question_id'] = $question['questionid'];
                $exam['questions'][$x]['text'] = $question['question'];
                $answers = array();
                $ansoption1 = array('id' => 'A', 'text' => $question['optiona']);
                $ansoption2 = array('id' => 'B', 'text' => $question['optionb']);
                $ansoption3 = array('id' => 'C', 'text' => $question['optionc']);
                $ansoption4 = array('id' => 'D', 'text' => $question['optiond']);
                
                array_push($answers, $ansoption1);
                array_push($answers, $ansoption2);
                array_push($answers, $ansoption3);
                array_push($answers, $ansoption4);
                $exam['questions'][$x]['answers'] = $answers;
          
            }
            return $exam;
        }
        function exam_results($examid, $userid)
        {
            //$this->db->select('userexam.*, jb_aot_person.showstatus, exams.examname, SUM(questions.marks) AS maxmarks, exams.passmark');
            $this->db->select('userexam.*, jb_aot_person.showstatus, exams.examname, exams.questions AS maxmarks, exams.passmark');
            $this->db->from('userexam');
            $this->db->join('exams', 'exams.examid = userexam.examid');
            $this->db->join('questions', 'questions.examid = userexam.examid');
			$this->db->join('jb_aot_person','userexam.examid = jb_aot_person.exam_id AND userexam.userid = jb_aot_person.user_id','LEFT OUTER');
            $this->db->where('userexam.userid', $userid);
            $this->db->where('userexam.examid', $examid);
            $this->db->group_by(array("userexam.userid", "jb_aot_person.showstatus", "exams.questions", "userexam.examid", "userexam.starttime", "userexam.endtime", "userexam.correctlyanswered", "userexam.status", "exams.examname", "exams.passmark")); 
            $exam_records = $this->db->get();
            if($exam_records->num_rows() > 0)
            {
                $results = array();
                $examdata = $exam_records->row();
                $results['duration'] = timeDiff($examdata->starttime, $examdata->endtime);
                $results['examname'] = $examdata->examname;
                $results['totalmarks'] = $examdata->maxmarks;
                $results['showstatus'] = $examdata->showstatus;
                $this->db->select('userquestions.questionid, userquestions.useranswer, questions.correctanswer,questions.marks');
                $this->db->from('userquestions');
                $this->db->join('questions', 'questions.questionid = userquestions.questionid');
                $this->db->where('userquestions.examid', $examid);
                $this->db->where('userquestions.userid', $userid);
                $allquestions = $this->db->get()->result_array();
                $marksobtained = 0;
                $failedquestions = array();
                foreach ($allquestions as  $questiondata) 
                {
                    if($questiondata['useranswer'] == $questiondata['correctanswer'])
                    {
                        $marksobtained += $questiondata['marks'];
                    }
                    else
                    {
                        $this->db->select('*');
                        $this->db->from('questions');
                        $this->db->where('questionid', $questiondata['questionid']);
                        $failed = $this->db->get()->row();
                        
                        $correctanswer = 'option'.strtolower($failed->correctanswer);
                        $youranswer = 'option'.strtolower($questiondata['useranswer']);
                        $question = array('question'=>$failed->question,
                                          'marks' => $failed->marks,
                                          'correctanswer'=>$failed->$correctanswer,
                                          'youranswer' => $failed->$youranswer
                                          );
                        array_push($failedquestions, $question);
                    }
                }
                $results['failedquestions'] = $failedquestions;
                $results['marksobtained'] = $marksobtained;
                $results['percentage'] = floor(($marksobtained / $examdata->maxmarks) * 100);
                if($results['percentage'] >= $examdata->passmark)
                {
                    $results['passed'] = true;
                }
                else
                {
                    $results['passed'] = false;
                }
            }

            return $results;

        }
        function get_exams_attempted($userid)
        {
            $this->db->select('userexam.examid, userexam.status, jb_aot_person.showstatus, exams.examname, exams.passmark');
            $this->db->from('userexam');
            $this->db->where('userexam.userid', $userid);
            $this->db->join('exams', 'exams.examid=userexam.examid');
			$this->db->join('jb_aot_person','userexam.examid = jb_aot_person.exam_id AND userexam.userid = jb_aot_person.user_id','LEFT OUTER');
            $examsdone = $this->db->get();
            $results = array();
            foreach ($examsdone->result_array() as $key => $exam) 
            {
            $results[$key]['exampassmark'] = $exam['passmark'];
            $results[$key]['examname'] = $exam['examname'];
            $results[$key]['examid'] = $exam['examid'];
            $results[$key]['showstatus'] = $exam['showstatus'];
            if($exam['status'] == 'completed')
            {
                $results[$key]['status'] = $exam['status'];
            }
            else
            {
                $results[$key]['status'] = 'Incomplete';
            }
            

            $examid =$exam['examid'];
            $this->db->select('SUM(questions.marks) AS maxmarks');
            $this->db->from('questions');
            $this->db->where('questions.examid', $examid);
            $maxmarks = $this->db->get()->row();

            $this->db->select('userquestions.questionid, userquestions.useranswer, questions.correctanswer,questions.marks');
            $this->db->from('userquestions');
            $this->db->join('questions', 'questions.questionid = userquestions.questionid');
            $this->db->where('userquestions.examid', $examid);
            $this->db->where('userquestions.userid', $userid);
            $allquestions = $this->db->get()->result_array();
            $marksobtained = 0;
            foreach ($allquestions as  $questiondata) 
            {
                if($questiondata['useranswer'] == $questiondata['correctanswer'])
                {
                    $marksobtained += $questiondata['marks'];
                }
            }
            $totalmarks = $maxmarks->maxmarks;
            $results[$key]['percentage'] = floor(($marksobtained / $totalmarks) * 100);  
            if($results[$key]['percentage'] >= $results[$key]['exampassmark'])
            {
                $results[$key]['passed'] = true;
            }
            else
            {
                $results[$key]['passed'] = false;
            } 
        }   
            return  $results;
        }
        
		/* DISC */
        function discdetails()
        {
           $this->db->select('disc_questionid'); 
           $this->db->from('disc_questions');
           $details = $this->db->get();
           return $details;
        }
        
        function get_disc_data()
        {

            $exam = array();

            $this->db->select('*');
            $this->db->from('disc_questions');
            $this->db->order_by('disc_questionid', 'asc');
            $result_questions = $this->db->get();

            $exam['questions'] = array();
            foreach ($result_questions->result_array() as $x => $question) 
            {
                $exam['questions'][$x]['question_id'] = $question['disc_questionid'];
                $exam['questions'][$x]['text'] = $question['question'];
                $answers = array();
                $this->db->select('*');
				$this->db->from('disc_option');
				$this->db->where('disc_questionid',$question['disc_questionid']);
				$result_option = $this->db->get();
				foreach ($result_option->result_array() as $option) 
				{
					$ansoption = array('id_m' => $option['option_mtype'], 'id_j' => $option['option_jtype'], 'text' => $option['option_desc']);
					array_push($answers, $ansoption);
				}
         
                $exam['questions'][$x]['answers'] = $answers;
          
            }
            return $exam;
        }
        
        function recorddisc_start($userid)
        {
			$this->db->where('userid', $userid);
			$this->db->delete('disc_user');
			$mbti_newstatus = array('userid'=>$userid);
			$this->db->set('starttime', 'NOW()', FALSE);
			$this->db->insert('disc_user', $mbti_newstatus);
        }
        
        function save_answer_disc($useranswer_m, $useranswer_j, $questionid, $userid)
        {
            $this->db->select('*');
            $this->db->from('disc_userquestions');
            $this->db->where('userid', $userid);
            $this->db->where('disc_questionid', $questionid);
            $result = $this->db->get();
            if($result->num_rows() > 0)
            {
            $question_status = array('answered' => 'answered', 'user_answer_m' => $useranswer_m, 'user_answer_j' => $useranswer_j);
            $this->db->where('userid', $userid);
            $this->db->where('disc_questionid', $questionid);
            $this->db->update('disc_userquestions',  $question_status);
            }
            else
            {
             $question_status = array('userid' => $userid,
                                      'disc_questionid' => $questionid,
                                      'answered' => 'answered', 
                                      'user_answer_m' => $useranswer_m, 
                                      'user_answer_j' => $useranswer_j);
             $this->db->insert('disc_userquestions', $question_status);
            }
        }
        
        function finish_user_disc($userid)
        {
            $exam_newstatus = array('endtime' => date('Y-m-d H:i:s'),
                                    'status' => 'completed'
                                    );
             $this->db->where('userid', $userid);
             $this->db->set('status', 'completed');
             $this->db->set('endtime', 'NOW()', FALSE);
             $this->db->update('disc_user');
             
        }
		/* End DISC */
		
        /* MBTI */
        function mbtidetails()
        {
           $this->db->select('mbti_questionid'); 
           $this->db->from('mbti_questions');
           $details = $this->db->get();
           return $details;
        }
        
        function get_mbti_data()
        {

            $exam = array();

            $this->db->select('*');
            $this->db->from('mbti_questions');
            $this->db->order_by('mbti_questionid', 'asc');
            $result_questions = $this->db->get();

            $exam['questions'] = array();
            foreach ($result_questions->result_array() as $x => $question) 
            {
                $exam['questions'][$x]['question_id'] = $question['mbti_questionid'];
                $exam['questions'][$x]['text'] = $question['question'];
                $answers = array();
                $this->db->select('*');
				$this->db->from('mbti_option');
				$this->db->where('mbti_questionid',$question['mbti_questionid']);
				$result_option = $this->db->get();
				foreach ($result_option->result_array() as $option) 
				{
					$ansoption = array('id' => $option['option_label'], 'text' => $option['option_desc']);
					array_push($answers, $ansoption);
				}
         
                $exam['questions'][$x]['answers'] = $answers;
          
            }
            return $exam;
        }
        
        function recordmbti_start($userid)
        {
			$this->db->where('userid', $userid);
			$this->db->delete('mbti_user');
			$mbti_newstatus = array('userid'=>$userid);
			$this->db->set('starttime', 'NOW()', FALSE);
			$this->db->insert('mbti_user', $mbti_newstatus);
        }
        
        function save_answer_mbti($useranswer, $questionid, $userid)
        {
            $this->db->select('*');
            $this->db->from('mbti_userquestions');
            $this->db->where('userid', $userid);
            $this->db->where('mbti_questionid', $questionid);
            $result = $this->db->get();
            if($result->num_rows() > 0)
            {
            $question_status = array('answered' => 'answered', 'user_answer' => $useranswer);
            $this->db->where('userid', $userid);
            $this->db->where('mbti_questionid', $questionid);
            $this->db->update('mbti_userquestions',  $question_status);
            }
            else
            {
             $question_status = array('userid' => $userid,
                                      'mbti_questionid' => $questionid,
                                      'answered' => 'answered', 
                                      'user_answer' => $useranswer);
             $this->db->insert('mbti_userquestions', $question_status);
            }
        }
        
        function finish_user_mbti($userid)
        {
            $exam_newstatus = array('endtime' => date('Y-m-d H:i:s'),
                                    'status' => 'completed'
                                    );
             $this->db->where('userid', $userid);
             $this->db->set('status', 'completed');
             $this->db->set('endtime', 'NOW()', FALSE);
             $this->db->update('mbti_user');
             
        }
		/* End MBTI */
}
?>
