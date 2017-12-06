<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Friend;

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
        $this->call(UsersTableSeeder::class);

        DB::statement('TRUNCATE course_slot CASCADE');
        DB::statement('TRUNCATE course_user CASCADE');
        DB::statement('TRUNCATE friendships CASCADE');
        DB::statement('TRUNCATE slots CASCADE');
        DB::statement('TRUNCATE courses CASCADE');


        $path = database_path('csv/FakeTeachersListW2017.csv');
        if (!file_exists($path) || !is_readable($path)) {
            echo "CSV insert failed: CSV " . $path . " does not exist or is not readable.";
            return FALSE;
        }
        echo "file read ok " . PHP_EOL;
        $handle = fopen($path, 'r');
        // CSV doesn't exist or couldn't be read from.
        if ($handle === FALSE)
            return [];

        //skip first line
        $row = fgetcsv($handle, 0, ',');
        $row_count = 0;

        //for ($i=0; $i<30; $i++){
        while (($row = fgetcsv($handle, 0, ',')) !== FALSE) {
            echo PHP_EOL . 'adding row #' . $row_count++ . '  ';
            echo $row[0] . $row[1] . $row[2] . $row[3] . $row[4] . $row[5];
            $this->insert($row);
        }
        echo 'added all ';


        //create random course enrollments for each student (6 courses per person)
        //for each user
        $users = User::all();
        foreach ($users as $user) {
            foreach (range(1, 6) as $i) {
                $user->courses()->attach(rand(1, 2000)); // give the user a random courseId
            }
        }
        echo "all users were assigned 6 random courses";


        //create random friendships
        $usersAll = User::all();
        echo 'size='.count($users);
        $users80 = $usersAll->take(80);

        foreach ($users80 as $user) {
            foreach(range(1, 6) as $i)
            {
            $newFriend = $usersAll[($user->id)+$i];

            $requester = new Friend;
            $receiver = new Friend;

            $requester->friend1_id = $user->id;
            $requester->friend1_name = $user->name;
            $requester->friend2_id = $newFriend->id;
            $requester->friend2_name = $newFriend->name;

            $receiver->friend1_id = $newFriend->id;
            $receiver->friend1_name = $newFriend->name;
            $receiver->friend2_id = $user->id;
            $receiver->friend2_name = $user->name;

            //make half of them pending requests
            if ($i <3 ) //1,2
            {
                $requester->status = "Sent";
                $receiver->status = "Received";
            }
            else if ($i >3 && $i <5) //3,4
            {
                $requester->status = "Confirmed";
                $receiver->status = "Confirmed";
            }
            else
            {
                $requester->status = "Received";
                $receiver->status = "Sent";
            }


            $requester->save();
            $receiver->save();

            }
        }



        echo "all users were assigned 6 random courses";

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
            echo 'duplicate course';
            $course_id = $course->id;     //save the id
        } else {                        //else add the entry
            echo 'adding course';
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
            ->where('starttime', $data[5])
            ->where('endtime', $data[6])->first();

        //if it already exists:
        if ($slot) {
            echo 'duplicate slot';
            $slot_id = $slot->id;
        } else { //else add the entry
            echo 'adding slot';
            DB::table('slots')->insert([
                'day' => $data[4],
                'starttime' => $data[5],
                'endtime' => $data[6]
            ]);
            //then query again to get the id

            $slot_id = DB::table('slots')->where('day', $data[4])
                ->where('starttime', $data[5])
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

