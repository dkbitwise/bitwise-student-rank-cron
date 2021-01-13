<?php

/**
 * Class Bitldlb_Student_Rank_Cron
 */
if ( ! class_exists( 'Bitldlb_Student_Rank_Cron' ) ) {
	class Bitldlb_Student_Rank_Cron {
		private static $ins = null;

		private $id = 0;
		private $student_id = 0;
		private $total_points = 0;
		private $point_rank = 0;
		private $total_badges = '';
		private $badge_rank = '';
		private $total_topic = '';
		private $topic_rank = '';
		private $total_time = '';
		private $time_rank = '';
		private $total_quiz = '';
		private $quiz_rank = '';
		private $total_questions = '';
		private $question_rank = '';
		private $updated_at = 0;

		private $bit_conn = null;
		private $table_name = '';
		private $table_prefix = '';

		/**
		 * Bitldlb_Student_Rank_Cron constructor.
		 */
		public function __construct() {
			$this->table_name   = 'bit_student_rank';
			$this->table_prefix = 'bit_';
			$this->bit_conn     = $this->get_connection();
		}

		/**
		 * @return Bitldlb_Student_Rank_Cron|null
		 */
		public static function get_instance() {
			if ( null === self::$ins ) {
				self::$ins = new self;
			}

			return self::$ins;
		}

		/**
		 * Setter function for course id
		 *
		 * @param $id
		 */
		public function set_id( $id ) {
			$this->id = $id;
		}

		/**
		 *  Setter function for student_id
		 *
		 * @param $student_id
		 */
		public function set_student_id( $student_id ) {
			$this->student_id = $student_id;
		}

		/**
		 * @param $total_points
		 */
		public function set_total_points( $total_points ) {
			$this->total_points = $total_points;
		}

		/**
		 * @param $point_rank
		 */
		public function set_point_rank( $point_rank ) {
			$this->point_rank = $point_rank;
		}

		/**
		 * @param $total_badges
		 */
		public function set_total_badges( $total_badges ) {
			$this->total_badges = $total_badges;
		}

		/**
		 * @param $badge_rank
		 */
		public function set_badge_rank( $badge_rank ) {
			$this->badge_rank = $badge_rank;
		}

		/**
		 * @param $total_topic
		 */
		public function set_total_topic( $total_topic ) {
			$this->total_topic = $total_topic;
		}

		/**
		 * @param $topic_rank
		 */
		public function set_topic_rank( $topic_rank ) {
			$this->topic_rank = $topic_rank;
		}

		/**
		 * @param $total_time
		 */
		public function set_total_time( $total_time ) {
			$this->total_time = $total_time;
		}

		/**
		 * @param $time_rank
		 */
		public function set_time_rank( $time_rank ) {
			$this->time_rank = $time_rank;
		}

		/**
		 * @param $total_quiz
		 */
		public function set_total_quiz( $total_quiz ) {
			$this->total_quiz = $total_quiz;
		}

		/**
		 * @param $quiz_rank
		 */
		public function set_quiz_rank( $quiz_rank ) {
			$this->quiz_rank = $quiz_rank;
		}

		/**
		 * @param $total_questions
		 */
		public function set_total_questions( $total_questions ) {
			$this->total_questions = $total_questions;
		}

		/**
		 * @param $question_rank
		 */
		public function set_question_rank( $question_rank ) {
			$this->question_rank = $question_rank;
		}

		/**
		 * @param $updated_at
		 */
		public function set_updated_at( $updated_at ) {
			$this->updated_at = $updated_at;
		}

		/**
		 * Getter function for points leader id
		 * @return int
		 */
		public function get_id() {
			return $this->id;
		}

		/**
		 * Getter function for student_id
		 * @return int
		 */
		public function get_student_id() {
			return $this->student_id;
		}


		/**
		 * Getter function for total_points
		 * @return string
		 */
		public function get_total_points() {
			return $this->total_points;
		}

		/**
		 * Getter function for point_rank
		 * @return string
		 */
		public function get_point_rank() {
			return $this->point_rank;
		}

		/**
		 * Getter function for total_badges
		 * @return string
		 */
		public function get_total_badges() {
			return $this->total_badges;
		}

		/**
		 * Getter function for total_badges
		 * @return string
		 */
		public function get_badge_rank() {
			return $this->badge_rank;
		}

		/**
		 * Getter function for total_topic
		 * @return string
		 */
		public function get_total_topic() {
			return $this->total_topic;
		}

		/**
		 * Getter function for topic_rank
		 * @return string
		 */
		public function get_topic_rank() {
			return $this->topic_rank;
		}

		/**
		 * Getter function for topic_rank
		 * @return string
		 */
		public function get_total_time() {
			return $this->total_time;
		}

		/**
		 * Getter function for time_rank
		 * @return string
		 */
		public function get_time_rank() {
			return $this->time_rank;
		}

		/**
		 * Getter function for total_quiz
		 * @return string
		 */
		public function get_total_quiz() {
			return $this->total_quiz;
		}

		/**
		 * Getter function for quiz_rank
		 * @return string
		 */
		public function get_quiz_rank() {
			return $this->quiz_rank;
		}

		/**
		 * Getter function for total_questions
		 * @return string
		 */
		public function get_total_questions() {
			return $this->total_questions;
		}

		/**
		 * Getter function for question_rank
		 * @return string
		 */
		public function get_question_rank() {
			return $this->question_rank;
		}

		/**
		 * Getter function for updated_at
		 * @return string
		 */
		public function get_updated_at() {
			return $this->updated_at;
		}

		/**
		 * @param array $setData
		 */
		public function save( $setData = array() ) {
			foreach ( is_array( $setData ) ? $setData : array() as $s_key => $s_value ) {
				$this->{$s_key} = $s_value;
			}

			$student_id = $this->get_student_id();

			$data                    = array();
			$data['student_id']      = $student_id;
			$data['total_points']    = empty( $this->get_total_points() ) ? 0 : $this->get_total_points();
			$data['point_rank']      = empty( $this->get_point_rank() ) ? 0 : $this->get_point_rank();
			$data['total_badges']    = empty( $this->get_total_badges() ) ? 0 : $this->get_total_badges();
			$data['badge_rank']      = empty( $this->get_badge_rank() ) ? 0 : $this->get_badge_rank();
			$data['total_topic']     = empty( $this->get_total_topic() ) ? 0 : $this->get_total_topic();
			$data['topic_rank']      = empty( $this->get_topic_rank() ) ? 0 : $this->get_topic_rank();
			$data['total_time']      = empty( $this->get_total_time() ) ? 0 : $this->get_total_time();
			$data['time_rank']       = empty( $this->get_time_rank() ) ? 0 : $this->get_time_rank();
			$data['total_quiz']      = empty( $this->get_total_quiz() ) ? 0 : $this->get_total_quiz();
			$data['quiz_rank']       = empty( $this->get_quiz_rank() ) ? 0 : $this->get_quiz_rank();
			$data['total_questions'] = empty( $this->get_total_questions() ) ? 0 : $this->get_total_questions();
			$data['question_rank']   = empty( $this->get_question_rank() ) ? 0 : $this->get_question_rank();
			$data['updated_at']      = empty( $this->get_updated_at() ) ? time() : $this->get_updated_at();

			if ( $this->bit_conn instanceof mysqli ) {

				$get_query  = "SELECT `id` FROM `$this->table_name` WHERE `student_id`=$student_id";
				$get_result = $this->bit_conn->query( $get_query );
				$final_sql  = '';
				$updated    = false;
				if ( $get_result->num_rows > 0 ) {
					$updated   = true;
					$final_sql = "update `bit_student_rank` SET ";
					foreach ( $data as $column => $value ) {
						$final_sql .= "$column = $value";
						if ( false !== next( $data ) ) {
							$final_sql .= ", ";
						}
					}
					$final_sql .= " WHERE `student_id`=$student_id";
				} else {
					$columns        = implode( ", ", array_keys( $data ) );
					$escaped_values = array_values( $data );
					$values         = implode( ", ", $escaped_values );
					$final_sql      = "INSERT INTO `$this->table_name` ($columns) VALUES ($values)";
				}

				if ( ! empty( $final_sql ) ) {
					$this->bit_conn->query( $final_sql );

					$message = 'Inserted';
					if ( $updated ) {
						$message = "Updated";
					}
					$message .= " data for student id: $student_id";

					echo "<br>" . $message;

					if ( ! empty( $this->bit_conn->error ) ) {
						echo '<br>Error: ';
						print_r( $this->bit_conn->error );
					}
				}
			}
		}

		public function get_connection() {
			$conn = new mysqli( "localhost", "root", "root", "bitwise" );
			// Check connection
			if ( $conn->connect_errno ) {
				echo "Failed to connect to MySQL: " . $conn->connect_error;
				exit();
			}

			return $conn;
		}

		public function update_rank() {
			$point_sql     = "SELECT `student_id`,`total_points` from " . $this->table_prefix . 'points_leader' . " ORDER BY `total_points` DESC";
			$point_results = $this->bit_conn->query( $point_sql );

			$topic_sql     = "SELECT `student_id`, count(`event_type`) as most_topic from " . $this->table_prefix . 'point_details' . " WHERE `event_type`='topic_completed' GROUP BY `student_id` order by most_topic DESC";
			$topic_results = $this->bit_conn->query( $topic_sql );

			$badge_sql     = "SELECT `student_id`, SUM(`badge_count`) as most_badge from " . $this->table_prefix . 'badge_leader' . " GROUP BY `student_id` order by most_badge DESC";
			$badge_results = $this->bit_conn->query( $badge_sql );

			$time_spent_sql = "SELECT `student_id`, SUM(`time_spent`) as most_time from " . $this->table_prefix . 'time_spent' . " GROUP BY `student_id` order by most_time DESC";
			$time_results   = $this->bit_conn->query( $time_spent_sql );

			$quiz_sql     = "SELECT `student_id`, `total_quiz` as most_quiz from " . $this->table_prefix . 'quiz_leader' . " GROUP BY `student_id` order by most_quiz DESC";
			$quiz_results = $this->bit_conn->query( $quiz_sql );

			$ques_sql     = "SELECT `student_id`, `total_questions` as most_questions from " . $this->table_prefix . 'quiz_leader' . " GROUP BY `student_id` order by most_questions DESC";
			$ques_results = $this->bit_conn->query( $ques_sql );

			$final_result = [];

			if ( $point_results->num_rows > 0 ) {
				$point_rank = 1;
				while ( $row = $point_results->fetch_assoc() ) {

					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_points'] = $row['total_points'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_points' => $row['total_points']
						);
					}
					$final_result[ $row['student_id'] ]['point_rank'] = $point_rank;
					$point_rank ++;
				}
			}

			if ( $topic_results->num_rows > 0 ) {
				$topic_rank = 1;
				while ( $row = $topic_results->fetch_assoc() ) {
					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_topic'] = $row['most_topic'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_topic' => $row['most_topic']
						);
					}
					$final_result[ $row['student_id'] ]['topic_rank'] = $topic_rank;
					$topic_rank ++;
				}
			}

			if ( $badge_results->num_rows > 0 ) {
				$badge_rank = 1;
				while ( $row = $badge_results->fetch_assoc() ) {
					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_badges'] = $row['most_badge'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_badges' => $row['most_badge']
						);
					}
					$final_result[ $row['student_id'] ]['badge_rank'] = $badge_rank;
					$badge_rank ++;
				}
			}

			if ( $time_results->num_rows > 0 ) {
				$time_rank = 1;
				while ( $row = $time_results->fetch_assoc() ) {
					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_time'] = $row['most_time'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_time' => $row['most_time']
						);
					}
					$final_result[ $row['student_id'] ]['time_rank'] = $time_rank;
					$time_rank ++;
				}
			}

			if ( $quiz_results->num_rows > 0 ) {
				$quiz_rank = 1;
				while ( $row = $quiz_results->fetch_assoc() ) {

					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_quiz'] = $row['most_quiz'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_quiz' => $row['most_quiz']
						);
					}
					$final_result[ $row['student_id'] ]['quiz_rank'] = $quiz_rank;
					$quiz_rank ++;
				}
			}

			if ( $ques_results->num_rows > 0 ) {
				$ques_rank = 1;
				while ( $row = $ques_results->fetch_assoc() ) {

					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_questions'] = $row['most_questions'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_questions' => $row['most_questions']
						);
					}
					$final_result[ $row['student_id'] ]['question_rank'] = $ques_rank;
					$ques_rank ++;
				}
			}

			foreach ( $final_result as $student_id => $result ) {
				$this->set_student_id( $student_id );
				foreach ( $result as $column => $value ) {
					$value = empty( $value ) ? 1 : $value;
					$this->{'set_' . $column}( $value );
				}
				$this->save();
			}
		}
	}

	$student_cron = Bitldlb_Student_Rank_Cron::get_instance();
	$student_cron->update_rank();
}