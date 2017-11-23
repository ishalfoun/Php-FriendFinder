<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $course_id;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

//        DB::table('courselist')->delete();
        $path = database_path('csv/FakeTeachersListW2017.csv');
        if ( !file_exists($path) || !is_readable($path) )
        {
            echo "CSV insert failed: CSV " . $path . " does not exist or is not readable.";
            return FALSE;
        }
        echo "file read ok ".PHP_EOL;
        $handle = fopen($path, 'r');
        // CSV doesn't exist or couldn't be read from.
        if ( $handle === FALSE )
            return [];

        //skip first line
        $row = fgetcsv($handle, 0, ',');
        $row_count = 0;

        //for ($i=0; $i<30; $i++)
        while ( ($row = fgetcsv($handle, 0, ',')) !== FALSE )
        {
            echo PHP_EOL.'adding row #'.$row_count++.'  ';
            $row = fgetcsv($handle, 0, ',');
            $this->insert($row);
        }
        echo 'added all ';

    }
    public function insert($data)
    {
        //insert course, then insert slot, then pass the two ids to insertCourseSlot
        $this->insertCourseSlot($this->insertCourse($data), $this->insertSlot($data));

    }

    public function insertCourse($data)
    {
        //search if it already exists
        $course = DB::table('courses')->where('class', $data[0])
            ->where('section', $data[1])
            ->where('title', $data[2])
            ->where('teacher', $data[3])->first();


        if ($course) {                  //if it already exists:
//            echo 'duplicate course ';
            $course_id=$course->id;     //save the id
        } else {                        //else add the entry
            echo 'adding:'.$data[0].' '.$data[1].' '.$data[2].' '.$data[3];
            DB::table('courses')->insert([
                'class' => $data[0],
                'section' => $data[1],
                'title' => $data[2],
                'teacher' => $data[3]
            ]);
            //then query again to get the id
            $course_id = DB::table('courses')->where('class', $data[0])
                ->where('section', $data[1])
                ->where('title', $data[2])
                ->where('teacher', $data[3])->first()->id;
        }
        return $course_id;
    }

    public function insertSlot($data)
    {
        //search if it already exists
        $slot = DB::table('slots')->where('day', $data[4])
            ->where('starttime',$data[5])
            ->where('endtime', $data[6])->first();

        //if it already exists:
        if ($slot){
            echo 'duplicate slot'.PHP_EOL;
            $slot_id=$slot->id;
        }
        else { //else add the entry
            echo 'adding:'.$data[4].' '.$data[5].' '.$data[6].PHP_EOL;
            DB::table('slots')->insert([
                'day' => $data[4],
                'starttime' => $data[5],
                'endtime' => $data[6]
            ]);
            //then query again to get the id

            $slot_id = DB::table('slots')->where('day', $data[4])
                ->where('starttime',$data[5])
                ->where('endtime', $data[6])->first()->id;
        }
        return $slot_id;
    }

    public function insertCourseSlot($course_id, $slot_id)
    {
        DB::table('course_slot')->insert([
            'course_id' => $course_id,
            'slot_id' => $slot_id,
        ]);
    }
}

