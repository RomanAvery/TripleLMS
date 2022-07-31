<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Course;
use App\Models\Topic;
use App\Models\Activity;
use App\Models\User;

use App\Models\TypesActivities\H5P;
use App\Models\TypesActivities\Qualtrics;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course_exists = false;

        // Only create course if it doesn't exist
        $course = Course::where('name', 'Internet of Things')->get()->first();
        if ($course !== null) {
            $course_exists = true;
        };

        $course = Course::updateOrCreate([
            'name' => 'Internet of Things',
        ]);

        $topics = [
            [
                'name' => 'Lesson 1: Course details',
                'activities' => [
                    [
                        'name' => 'Pre-Course Survey',
                        'content' => Qualtrics::make([
                            'link' => 'https://vuw.qualtrics.com/jfe/form/SV_8BUUZv8jyD8papo',
                        ]),
                    ],
                    [
                        'name' => 'Course Overview',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291628815245990239',
                        ]),
                    ],
                ]
            ],
            [
                'name' => 'Lesson 2: What is IoT?',
                'activities' => [
                    [
                        'name' => 'Introduction to IoT',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291616859351462409',
                        ]),
                    ],
                    [
                        'name' => 'Extension - Intro to IoT',
                        'required' => false,
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291616864977532379',
                        ]),
                    ],
                ]
            ],
            [
                'name' => 'Lesson 3: Use cases of IoT',
                'activities' => [
                    [
                        'name' => 'Use Cases of IoT',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291617718878129779',
                        ]),
                    ],
                    [
                        'name' => 'Quiz',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291617734559256809',
                        ]),
                    ],
                    [
                        'name' => 'Spark Story',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291617729659258209',
                        ]),
                    ],
                    [
                        'name' => 'Examples of IoT around you',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291617737948037429',
                        ]),
                    ],
                ]
            ],
            [
                'name' => 'Lesson 4: How it works',
                'activities' => [
                    /*[
                        'name' => '',
                        'content' => H5P::make([
                            'link' => '',
                        ]),
                    ],*/
                ]
            ],
            [
                'name' => 'Lesson 5: Industry Professionals',
                'activities' => []
            ],
            [
                'name' => 'Lesson 6a: Intro to Microbit',
                'activities' => [
                    [
                        'name' => 'Introduction to Microbit',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291624581395377299',
                        ]),
                    ],
                    [
                        'name' => 'Identify the Microbit components',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291624587023276019',
                        ]),
                    ],
                    [
                        'name' => 'Setup and Programming first steps',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291624615318067299',
                        ]),
                    ],
                ]
            ],
            [
                'name' => 'Lesson 6b: Intro to IoT Shield',
                'activities' => [
                    [
                        'name' => 'Introduction to the Environment Science Expansion Board',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291679998537313599',
                        ]),
                    ],
                ]
            ],
            [
                'name' => 'Lesson 7: Project',
                'activities' => [
                    [
                        'name' => 'Individual Projects',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291702301106059759',
                        ]),
                    ],
                    [
                        'name' => 'My Personal Project',
                        'content' => H5P::make([
                            'link' => 'https://vuwcourses.h5p.com/content/1291702303280850009',
                        ]),
                    ],
                ]
            ],
        ];

        foreach ($topics as $topic) {
            // Make topic
            $t = Topic::updateOrCreate([
                'name' => $topic['name'],
                'course_id' => $course->id,
            ]);

            // Add topic to course
            $course->topics()->save($t);

            foreach ($topic['activities'] as $activity) {
                $c = $activity['content'];

                // Try to find activity
                $a = Activity::where('name', $activity['name'])
                    ->where('topic_id', $t->id)
                    ->get()->first();

                if ($a === null) {
                    $a = Activity::make([
                        'name' => $activity['name'],
                        'topic_id' => $t->id,
                    ]);
                }
                
                $a->activityable_type = get_class($c);
                $a->link = $c->link;
                $a->save();

                // Save activity to topics
                $t->activities()->save($a);
            }
        }

        // Add every user to this course.
        if (!$course_exists) {
            $course->users()->saveMany(User::all());
        }
    }
}
