<?php

/**
 * Class Bitldlb_Rank_Details
 */
if ( ! class_exists( 'Bitldlb_Rank_Details' ) ) {
	class Bitldlb_Rank_Details {
		private static $ins = null;

		private $id = 0;
		private $top_rankers = '';
		private $updated_at = 0;

		private $bit_conn = null;
		private $table_name = '';
		private $table_prefix = '';

		/**
		 * Bitldlb_Student_Rank_Cron constructor.
		 */
		public function __construct() {
			$this->table_name   = 'bit_rank_details';
			$this->table_prefix = 'bit_';
			$this->bit_conn     = $this->get_connection();
		}

		/**
		 * @return Bitldlb_Rank_Details|null
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
		 * @param $top_rankers
		 */
		public function set_top_rankers( $top_rankers ) {
			$this->top_rankers = $top_rankers;
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
		 * Getter function for top_rankers
		 * @return string
		 */
		public function get_top_rankers() {
			return $this->top_rankers;
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

			$data                = array();
			$data['top_rankers'] = serialize($this->get_top_rankers());
			$data['updated_at']  = empty( $this->get_updated_at() ) ? time() : $this->get_updated_at();

			if ( $this->bit_conn instanceof mysqli ) {
				$columns        = implode( ", ", array_keys( $data ) );
				$final_sql      = "INSERT INTO `$this->table_name` ($columns) VALUES ('$data[top_rankers]',$data[updated_at])";
				echo $final_sql;

				$this->bit_conn->query( $final_sql );
				$insert_id = $this->bit_conn->insert_id;
				echo "<br>Inserted data with id: " . $insert_id;

				if ( ! empty( $this->bit_conn->error ) ) {
					echo '<br>Error: ';
					print_r( $this->bit_conn->error );
				}
			}
		}

		public function get_connection() {
			$conn = new mysqli( "localhost", "bitwise", "b1tW1$!07E4", "bw_academy" );
			// Check connection
			if ( $conn->connect_errno ) {
				echo "Failed to connect to MySQL: " . $conn->connect_error;
				exit();
			}

			return $conn;
		}

		public function update_rank_details() {
			$point_results    = $this->get_query_type_result( 'point' );
			$topic_results    = $this->get_query_type_result( 'topic' );
			$badge_results    = $this->get_query_type_result( 'badge' );
			$time_results     = $this->get_query_type_result( 'time' );
			$quiz_results     = $this->get_query_type_result( 'quiz' );
			$question_results = $this->get_query_type_result( 'question' );

			$final_result = [];

			if ( $point_results->num_rows > 0 ) {
				while ( $row = $point_results->fetch_assoc() ) {
					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_points'] = $row['total_points'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_points' => $row['total_points']
						);
					}
					$final_result[ $row['student_id'] ]['point_rank'] = $row['point_rank'];
				}
			}

			if ( $topic_results->num_rows > 0 ) {
				$topic_rank = 1;
				while ( $row = $topic_results->fetch_assoc() ) {
					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_topic'] = $row['total_topic'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_topic' => $row['total_topic']
						);
					}
					$final_result[ $row['student_id'] ]['topic_rank'] = $row['topic_rank'];
					$topic_rank ++;
				}
			}

			if ( $badge_results->num_rows > 0 ) {
				while ( $row = $badge_results->fetch_assoc() ) {
					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_badges'] = $row['total_badges'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_badges' => $row['total_badges']
						);
					}
					$final_result[ $row['student_id'] ]['badge_rank'] = $row['badge_rank'];
				}
			}

			if ( $time_results->num_rows > 0 ) {
				while ( $row = $time_results->fetch_assoc() ) {
					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_time'] = $row['total_time'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_time' => $row['total_time']
						);
					}
					$final_result[ $row['student_id'] ]['time_rank'] = $row['time_rank'];
				}
			}

			if ( $quiz_results->num_rows > 0 ) {
				while ( $row = $quiz_results->fetch_assoc() ) {
					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_quiz'] = $row['total_quiz'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_quiz' => $row['total_quiz']
						);
					}
					$final_result[ $row['student_id'] ]['quiz_rank'] = $row['quiz_rank'];
				}
			}

			if ( $question_results->num_rows > 0 ) {
				while ( $row = $question_results->fetch_assoc() ) {
					if ( isset( $final_result[ $row['student_id'] ] ) ) {
						$final_result[ $row['student_id'] ]['total_questions'] = $row['total_questions'];
					} else {
						$final_result[ $row['student_id'] ] = array(
							'total_questions' => $row['total_questions']
						);
					}
					$final_result[ $row['student_id'] ]['question_rank'] = $row['question_rank'];
				}
			}

			$this->set_top_rankers( $final_result );
			$this->save();
		}

		/**
		 * @param $type
		 *
		 * @return array|object
		 */
		public function get_query_type_result( $type ) {
			$type_sql = '';
			$last_30  = strtotime( '-30 days' );
			switch ( $type ) {
				case 'point':
					$type_sql = "SELECT `student_id`,`total_points`,`point_rank` FROM " . $this->table_prefix . 'student_rank' . " WHERE `updated_at`>$last_30 ORDER BY `total_points` DESC LIMIT 5";
					break;

				case 'topic':
					$type_sql = "SELECT `student_id`,`total_topic`,`topic_rank` FROM " . $this->table_prefix . 'student_rank' . " WHERE `updated_at`>$last_30 ORDER BY `total_topic` DESC LIMIT 5";
					break;

				case 'badge':
					$type_sql = "SELECT `student_id`,`total_badges`,`badge_rank` FROM " . $this->table_prefix . 'student_rank' . " WHERE `updated_at`>$last_30 ORDER BY `total_badges` DESC LIMIT 5";
					break;

				case 'time':
					$type_sql = "SELECT `student_id`,`total_time`,`time_rank` FROM " . $this->table_prefix . 'student_rank' . " WHERE `updated_at`>$last_30 ORDER BY `total_time` DESC LIMIT 5";
					break;

				case 'quiz':
					$type_sql = "SELECT `student_id`,`total_quiz`,`quiz_rank` FROM " . $this->table_prefix . 'student_rank' . " WHERE `updated_at`>$last_30 ORDER BY `total_quiz` DESC LIMIT 5";
					break;

				case 'question':
					$type_sql = "SELECT `student_id`,`total_questions`,`question_rank` FROM " . $this->table_prefix . 'student_rank' . " WHERE `updated_at`>$last_30 ORDER BY `total_questions` DESC LIMIT 5";
					break;
			}

			if ( ! empty( $type_sql ) ) {
				return $this->bit_conn->query( $type_sql );
			}

			return null;
		}
	}

	$top_cron = Bitldlb_Rank_Details::get_instance();
	$top_cron->update_rank_details();
}