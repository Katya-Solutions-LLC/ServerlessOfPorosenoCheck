<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeeRatingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('employee_rating')->delete();
        
        \DB::table('employee_rating')->insert(array (
            0 => 
            array (
                'id' => 1,
                'employee_id' => 12,
                'user_id' => 2,
                'review_msg' => 'Excellent Feeding and Watering service! My pet was well-nourished and hydrated throughout the stay. Highly recommend! ❤️🤩',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            1 => 
            array (
                'id' => 2,
                'employee_id' => 13,
                'user_id' => 5,
                'review_msg' => 'I appreciate the updates and photos you sent while my pet was boarding with you. It put my mind at ease knowing they were in good hands. 😍💥',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            2 => 
            array (
                'id' => 3,
                'employee_id' => 14,
                'user_id' => 4,
                'review_msg' => 'Thank you for taking such wonderful care of my fur baby during their boarding. Your love and attention made all the difference!🎊💥',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            3 => 
            array (
                'id' => 4,
                'employee_id' => 15,
                'user_id' => 9,
                'review_msg' => 'I couldn\'t have asked for a better caretaker! My pet was happy, healthy, and clearly well-loved throughout their stay.💕😊 ',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            4 => 
            array (
                'id' => 5,
                'employee_id' => 16,
                'user_id' => 8,
                'review_msg' => 'Your passion for animals shines through your work. I\'m grateful my pet had you as their caretaker during boarding.❤️🥰 ',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            5 => 
            array (
                'id' => 6,
                'employee_id' => 17,
                'user_id' => 10,
                'review_msg' => 'You are a true professional with a heart of gold. My pet returned home happy and content after their time with you.🤩😊 ',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            6 => 
            array (
                'id' => 7,
                'employee_id' => 18,
                'user_id' => 5,
                'review_msg' => 'Excellent General Veterinary Care service! Highly recommend for comprehensive and compassionate pet care🥰😊',
                'rating' => 3.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            7 => 
            array (
                'id' => 8,
                'employee_id' => 24,
                'user_id' => 4,
                'review_msg' => 'Thank you, Dr. Erica, for taking such great care of my fur baby during boarding! Your expertise and compassion put my mind at ease.💥🎊',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            8 => 
            array (
                'id' => 9,
                'employee_id' => 23,
                'user_id' => 3,
                'review_msg' => 'Excellent and attentive care for my furry friend - highly recommended! 🎉🎊',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            9 => 
            array (
                'id' => 10,
                'employee_id' => 20,
                'user_id' => 7,
                'review_msg' => 'Dr. Daniel\'s boarding services were outstanding! My pet received the best medical attention and love, making the experience worry-free.😊 ',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            10 => 
            array (
                'id' => 11,
                'employee_id' => 19,
                'user_id' => 8,
                'review_msg' => 'Highly recommend Dr. Jorge\'s boarding services - my pet was in safe hands, and the personalized care was exceptional. ❤️🎊',
                'rating' => 3.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            11 => 
            array (
                'id' => 12,
                'employee_id' => 22,
                'user_id' => 9,
                'review_msg' => 'The level of care provided by Dr. Erik is unmatched. My pet receives the best treatment and attention under his expertise. 🥰 ❤️',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            12 => 
            array (
                'id' => 13,
                'employee_id' => 21,
                'user_id' => 11,
                'review_msg' => 'Dr. Jose\'s gentle approach and warm demeanor create a comfortable atmosphere for my pet\'s visits. Grateful to have such a caring vet.💥😍',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            13 => 
            array (
                'id' => 14,
                'employee_id' => 25,
                'user_id' => 2,
                'review_msg' => 'Exceptional grooming services! The groomer paid meticulous attention to detail, leaving my pet looking and feeling fantastic.😊😍',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            14 => 
            array (
                'id' => 15,
                'employee_id' => 26,
                'user_id' => 2,
                'review_msg' => 'Highly skilled groomer who made my pet feel comfortable and pampered throughout the grooming session.💥💕🤩',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            15 => 
            array (
                'id' => 16,
                'employee_id' => 30,
                'user_id' => 3,
                'review_msg' => 'Impressed by the groomer\'s talent; my pet\'s coat has never looked so smooth and well-groomed.🥳🤩',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            16 => 
            array (
                'id' => 17,
                'employee_id' => 29,
                'user_id' => 4,
                'review_msg' => 'The groomer was patient and understanding with my pet\'s specific grooming needs, providing a wonderful experience.🥳🎊',
                'rating' => 3.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            17 => 
            array (
                'id' => 18,
                'employee_id' => 27,
                'user_id' => 5,
                'review_msg' => 'A big thank you to the groomer for their professionalism and care in making my pet look adorable.😊 🤩',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            18 => 
            array (
                'id' => 19,
                'employee_id' => 28,
                'user_id' => 6,
                'review_msg' => 'Outstanding grooming service! My pet enjoyed the session, and I\'ll definitely be returning for more grooming sessions.🥳🎉',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            19 => 
            array (
                'id' => 20,
                'employee_id' => 34,
                'user_id' => 6,
                'review_msg' => 'Outstanding Training services! The Trainer\'s expertise and patience helped my pet learn new skills effectively.❤️🎉',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            20 => 
            array (
                'id' => 21,
                'employee_id' => 35,
                'user_id' => 7,
                'review_msg' => 'Highly recommended Trainer! Their personalized approach made the training sessions enjoyable and productive.🎊🥰 ',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            21 => 
            array (
                'id' => 22,
                'employee_id' => 36,
                'user_id' => 8,
                'review_msg' => 'Impressed by the Trainer\'s professionalism and ability to address my pet\'s specific needs.❤️💥',
                'rating' => 3.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            22 => 
            array (
                'id' => 23,
                'employee_id' => 33,
                'user_id' => 10,
                'review_msg' => 'Great results achieved with the Trainer\'s guidance; my pet\'s behavior improved significantly.🤩😊',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 12:20:51',
            ),
            23 => 
            array (
                'id' => 24,
                'employee_id' => 37,
                'user_id' => 2,
                'review_msg' => 'The Trainer\'s positive reinforcement techniques created a strong bond between my pet and me.💕🥰 ',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            24 => 
            array (
                'id' => 25,
                'employee_id' => 39,
                'user_id' => 3,
                'review_msg' => 'Absolutely delighted with the walking services! The walker was attentive and my pet returned happy and energized. 💕😍',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 08:00:36',
            ),
            25 => 
            array (
                'id' => 26,
                'employee_id' => 43,
                'user_id' => 6,
                'review_msg' => 'The walker showed genuine care and patience, making each walk enjoyable for my furry companion.🥰 ',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            26 => 
            array (
                'id' => 27,
                'employee_id' => 44,
                'user_id' => 9,
                'review_msg' => 'Highly recommend the walking services; the walker\'s reliability and rapport with my pet were impressive.💥❤️',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            27 => 
            array (
                'id' => 28,
                'employee_id' => 40,
                'user_id' => 7,
                'review_msg' => 'My pet and I both adore the walker; they always go the extra mile to ensure a great walking experience.🥳💕',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            28 => 
            array (
                'id' => 29,
                'employee_id' => 41,
                'user_id' => 10,
                'review_msg' => 'Trustworthy and responsible walker, I feel at ease knowing my pet is in safe hands during walks. 🥰',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 06:20:30',
            ),
            29 => 
            array (
                'id' => 30,
                'employee_id' => 45,
                'user_id' => 8,
                'review_msg' => 'Outstanding Day Care service! The Day Care Taker took great care of my pet, providing a safe and fun environment.🥰 ❤️',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            30 => 
            array (
                'id' => 31,
                'employee_id' => 47,
                'user_id' => 9,
                'review_msg' => 'I\'m thrilled with the Day Care services and the Day Care Taker\'s attentiveness to my pet\'s needs.💥💕',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            31 => 
            array (
                'id' => 32,
                'employee_id' => 50,
                'user_id' => 11,
                'review_msg' => 'Highly recommended Day Care Taker! My pet always comes home happy and well-cared for. 😎💕',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 07:04:04',
            ),
            32 => 
            array (
                'id' => 33,
                'employee_id' => 49,
                'user_id' => 2,
                'review_msg' => 'The Day Care Taker\'s genuine love for animals shines through, making the Day Care experience truly special.💕😍',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            33 => 
            array (
                'id' => 34,
                'employee_id' => 46,
                'user_id' => 3,
                'review_msg' => 'Reliable and caring Day Care service; I trust the Day Care Taker completely with my furry friend.😍💥',
                'rating' => 4.5,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            34 => 
            array (
                'id' => 35,
                'employee_id' => 48,
                'user_id' => 6,
                'review_msg' => 'Thanks to the Day Care Taker, my pet eagerly looks forward to each visit - a sign of excellent Day Care services!🥳🥰 ',
                'rating' => 3.0,
                'created_at' => '2023-08-26 05:15:31',
                'updated_at' => '2023-08-26 05:15:31',
            ),
            35 => 
            array (
                'id' => 36,
                'employee_id' => 17,
                'user_id' => 9,
                'review_msg' => 'Top-notch boarding experience - my pet was in safe hands and came back happy! 😍',
                'rating' => 5.0,
                'created_at' => '2023-08-26 05:57:00',
                'updated_at' => '2023-08-26 05:57:00',
            ),
            36 => 
            array (
                'id' => 37,
                'employee_id' => 28,
                'user_id' => 8,
                'review_msg' => 'Effective and thorough flea and tick treatment – my pet is relieved and refreshed! 🥰🥳',
                'rating' => 4.0,
                'created_at' => '2023-08-26 06:11:45',
                'updated_at' => '2023-08-26 06:11:52',
            ),
            37 => 
            array (
                'id' => 38,
                'employee_id' => 31,
                'user_id' => 10,
                'review_msg' => 'A pampering experience that left my pet relaxed and rejuvenated. Highly recommended!💕😍',
                'rating' => 5.0,
                'created_at' => '2023-08-26 06:16:24',
                'updated_at' => '2023-08-26 06:16:24',
            ),
            38 => 
            array (
                'id' => 39,
                'employee_id' => 19,
                'user_id' => 6,
                'review_msg' => 'Highly skilled team providing exceptional reproductive care for my pet. A true lifesaver❤️💥',
                'rating' => 4.0,
                'created_at' => '2023-08-26 06:29:56',
                'updated_at' => '2023-08-26 06:30:53',
            ),
            39 => 
            array (
                'id' => 40,
                'employee_id' => 20,
                'user_id' => 6,
                'review_msg' => 'Exceptional veterinary care that truly understands and cares for my pet\'s needs. 😍🧑‍⚕️',
                'rating' => 5.0,
                'created_at' => '2023-08-26 06:50:31',
                'updated_at' => '2023-08-26 06:50:31',
            ),
            40 => 
            array (
                'id' => 41,
                'employee_id' => 13,
                'user_id' => 3,
                'review_msg' => 'Exceptional care and love for my furry friend during their stay. Couldn\'t be happier! 🎉🥳❤️',
                'rating' => 4.0,
                'created_at' => '2023-08-26 07:57:40',
                'updated_at' => '2023-08-26 07:57:40',
            ),
            41 => 
            array (
                'id' => 42,
                'employee_id' => 35,
                'user_id' => 3,
                'review_msg' => 'Transformative training that brought out the best in my beloved pet. 💕😎',
                'rating' => 4.0,
                'created_at' => '2023-08-26 07:59:09',
                'updated_at' => '2023-08-26 07:59:09',
            ),
            42 => 
            array (
                'id' => 43,
                'employee_id' => 44,
                'user_id' => 3,
                'review_msg' => 'Exceptional dog walking service - my pet eagerly awaits their walks with excitement! 🥰🤩',
                'rating' => 5.0,
                'created_at' => '2023-08-26 07:59:43',
                'updated_at' => '2023-08-26 07:59:43',
            ),
            43 => 
            array (
                'id' => 44,
                'employee_id' => 25,
                'user_id' => 3,
                'review_msg' => 'Impeccable grooming service that leaves my pet looking and feeling fantastic.😎🤓💯',
                'rating' => 4.0,
                'created_at' => '2023-08-26 08:01:59',
                'updated_at' => '2023-08-26 08:01:59',
            ),
            44 => 
            array (
                'id' => 45,
                'employee_id' => 13,
                'user_id' => 11,
                'review_msg' => 'A fantastic home away from home for my pet. Professional and caring service. 💕😍',
                'rating' => 5.0,
                'created_at' => '2023-08-26 08:06:08',
                'updated_at' => '2023-08-26 08:06:08',
            ),
            45 => 
            array (
                'id' => 46,
                'employee_id' => 33,
                'user_id' => 11,
                'review_msg' => 'Highly effective training service that forged a strong bond with my pet. 🤓😎🤗',
                'rating' => 5.0,
                'created_at' => '2023-08-26 08:09:05',
                'updated_at' => '2023-08-26 12:19:27',
            ),
            46 => 
            array (
                'id' => 47,
                'employee_id' => 45,
                'user_id' => 11,
                'review_msg' => 'Exceptional pet care provider, my furry friend always comes home happy! 😍💕🤗',
                'rating' => 5.0,
                'created_at' => '2023-08-26 08:12:50',
                'updated_at' => '2023-08-26 12:55:16',
            ),
            47 => 
            array (
                'id' => 48,
                'employee_id' => 26,
                'user_id' => 11,
                'review_msg' => 'Highly skilled groomers who pamper my pet with care and style. 🤓🤩',
                'rating' => 5.0,
                'created_at' => '2023-08-26 08:15:14',
                'updated_at' => '2023-08-26 08:15:14',
            ),
            48 => 
            array (
                'id' => 49,
                'employee_id' => 40,
                'user_id' => 11,
                'review_msg' => 'A lifesaver! These walkers have transformed my pet\'s energy and behavior positively. 🧑‍💼🥰',
                'rating' => 5.0,
                'created_at' => '2023-08-26 08:18:50',
                'updated_at' => '2023-08-26 08:18:50',
            ),
            49 => 
            array (
                'id' => 50,
                'employee_id' => 38,
                'user_id' => 10,
                'review_msg' => 'Exceptional trainers who turned my pet\'s behavior around with care.😎😍🥰',
                'rating' => 4.0,
                'created_at' => '2023-08-26 09:10:14',
                'updated_at' => '2023-08-26 12:54:14',
            ),
            50 => 
            array (
                'id' => 51,
                'employee_id' => 41,
                'user_id' => 9,
                'review_msg' => 'Professional and dedicated walkers who truly understand and connect with my pet\'s needs. 🤩🎉',
                'rating' => 5.0,
                'created_at' => '2023-08-26 09:11:35',
                'updated_at' => '2023-08-26 09:11:35',
            ),
            51 => 
            array (
                'id' => 52,
                'employee_id' => 27,
                'user_id' => 9,
                'review_msg' => 'Exceptional grooming experience that keeps my pet\'s tail wagging with joy.😊🤗',
                'rating' => 5.0,
                'created_at' => '2023-08-26 09:19:22',
                'updated_at' => '2023-08-26 09:19:22',
            ),
            52 => 
            array (
                'id' => 53,
                'employee_id' => 40,
                'user_id' => 9,
                'review_msg' => 'An excellent walker who treats my pet with care and enthusiasm.❤️🥳',
                'rating' => 4.0,
                'created_at' => '2023-08-26 09:26:36',
                'updated_at' => '2023-08-26 09:26:36',
            ),
            53 => 
            array (
                'id' => 54,
                'employee_id' => 24,
                'user_id' => 9,
                'review_msg' => 'A top-notch veterinary service that prioritizes my pet\'s well-being and health. 💕💯',
                'rating' => 4.0,
                'created_at' => '2023-08-26 09:28:10',
                'updated_at' => '2023-08-26 09:28:10',
            ),
            54 => 
            array (
                'id' => 55,
                'employee_id' => 27,
                'user_id' => 8,
                'review_msg' => 'A grooming service that consistently delivers perfection, tailored to my pet. 😊😍',
                'rating' => 5.0,
                'created_at' => '2023-08-26 09:42:41',
                'updated_at' => '2023-08-26 12:52:54',
            ),
            55 => 
            array (
                'id' => 56,
                'employee_id' => 18,
                'user_id' => 7,
                'review_msg' => 'Reliable and compassionate veterinary care that I can always trust.🧑‍⚕️🤗',
                'rating' => 4.0,
                'created_at' => '2023-08-26 09:49:17',
                'updated_at' => '2023-08-26 09:49:17',
            ),
            56 => 
            array (
                'id' => 57,
                'employee_id' => 14,
                'user_id' => 6,
                'review_msg' => 'Impeccable facilities and attentive staff. My pet\'s new favorite place to stay! 😊💯',
                'rating' => 4.0,
                'created_at' => '2023-08-26 10:14:47',
                'updated_at' => '2023-08-26 10:14:47',
            ),
            57 => 
            array (
                'id' => 58,
                'employee_id' => 25,
                'user_id' => 5,
                'review_msg' => 'A grooming service that consistently delivers perfection. 🐈🥰',
                'rating' => 4.0,
                'created_at' => '2023-08-26 10:34:26',
                'updated_at' => '2023-08-26 10:34:34',
            ),
            58 => 
            array (
                'id' => 59,
                'employee_id' => 47,
                'user_id' => 4,
                'review_msg' => 'Trustworthy and attentive; my pet loves their time at this daycare.😊🤗',
                'rating' => 5.0,
                'created_at' => '2023-08-26 10:41:14',
                'updated_at' => '2023-08-26 10:41:14',
            ),
            59 => 
            array (
                'id' => 60,
                'employee_id' => 21,
                'user_id' => 3,
                'review_msg' => 'Five-star care from knowledgeable veterinarians who treat my pet like family. 🧑‍⚕️💯',
                'rating' => 4.0,
                'created_at' => '2023-08-26 11:04:16',
                'updated_at' => '2023-08-26 11:04:16',
            ),
            60 => 
            array (
                'id' => 61,
                'employee_id' => 23,
                'user_id' => 10,
                'review_msg' => 'Reliable and compassionate veterinary care that I can always trust. 💯',
                'rating' => 4.0,
                'created_at' => '2023-08-26 11:45:20',
                'updated_at' => '2023-08-26 11:45:20',
            ),
            61 => 
            array (
                'id' => 62,
                'employee_id' => 48,
                'user_id' => 11,
                'review_msg' => 'A fantastic daycare with caring staff, my pet\'s second home. 🤗',
                'rating' => 5.0,
                'created_at' => '2023-08-26 11:49:40',
                'updated_at' => '2023-08-26 11:49:40',
            ),
            62 => 
            array (
                'id' => 63,
                'employee_id' => 25,
                'user_id' => 7,
                'review_msg' => 'Top-tier pet pampering that transforms my furry friend into a masterpiece. 😊☺️',
                'rating' => 4.0,
                'created_at' => '2023-08-26 11:51:56',
                'updated_at' => '2023-08-26 11:51:56',
            ),
            63 => 
            array (
                'id' => 64,
                'employee_id' => 47,
                'user_id' => 5,
                'review_msg' => 'Reliable and loving care that makes my pet wag with joy! 😊🥰👏',
                'rating' => 5.0,
                'created_at' => '2023-08-26 11:55:01',
                'updated_at' => '2023-08-26 12:47:48',
            ),
            64 => 
            array (
                'id' => 65,
                'employee_id' => 34,
                'user_id' => 8,
                'review_msg' => 'Professional training that made a remarkable difference in my pet\'s obedience. 😍🤩',
                'rating' => 5.0,
                'created_at' => '2023-08-26 11:59:24',
                'updated_at' => '2023-08-26 11:59:24',
            ),
            65 => 
            array (
                'id' => 66,
                'employee_id' => 27,
                'user_id' => 4,
                'review_msg' => 'Top-tier pet pampering that transforms my furry friend into a masterpiece. 🤗😊',
                'rating' => 4.0,
                'created_at' => '2023-08-26 12:01:08',
                'updated_at' => '2023-08-26 12:01:08',
            ),
            66 => 
            array (
                'id' => 67,
                'employee_id' => 14,
                'user_id' => 9,
                'review_msg' => 'Trustworthy and wonderful boarding service. My pet was treated like family. 😍🤗👏',
                'rating' => 5.0,
                'created_at' => '2023-08-26 12:05:16',
                'updated_at' => '2023-08-26 12:53:31',
            ),
            67 => 
            array (
                'id' => 68,
                'employee_id' => 23,
                'user_id' => 7,
                'review_msg' => 'Outstanding pet care service that goes above and beyond in every aspect. 🧑‍⚕️😍',
                'rating' => 5.0,
                'created_at' => '2023-08-26 12:06:29',
                'updated_at' => '2023-08-26 12:06:29',
            ),
            68 => 
            array (
                'id' => 69,
                'employee_id' => 35,
                'user_id' => 6,
                'review_msg' => 'Incredible training experience that made both me and my pet happier.🤗😊',
                'rating' => 5.0,
                'created_at' => '2023-08-26 12:07:27',
                'updated_at' => '2023-08-26 12:07:27',
            ),
            69 => 
            array (
                'id' => 70,
                'employee_id' => 14,
                'user_id' => 5,
                'review_msg' => 'Exceptional boarding service that gave my pet a comfortable home away from home. 😍',
                'rating' => 4.0,
                'created_at' => '2023-08-26 12:10:52',
                'updated_at' => '2023-08-26 12:10:52',
            ),
            70 => 
            array (
                'id' => 71,
                'employee_id' => 42,
                'user_id' => 4,
                'review_msg' => 'Trustworthy and dependable - my pet\'s walks are always a joy. ☺️',
                'rating' => 4.0,
                'created_at' => '2023-08-26 12:12:09',
                'updated_at' => '2023-08-26 12:12:09',
            ),
            71 => 
            array (
                'id' => 72,
                'employee_id' => 15,
                'user_id' => 3,
                'review_msg' => 'Trustworthy and attentive—my pet was in great hands during the stay. 🥰🤩',
                'rating' => 5.0,
                'created_at' => '2023-08-26 12:13:04',
                'updated_at' => '2023-08-26 12:13:04',
            ),
            72 => 
            array (
                'id' => 73,
                'employee_id' => 35,
                'user_id' => 11,
                'review_msg' => 'An exceptional trainer who understands and connects with my pet perfectly. 🥰',
                'rating' => 4.0,
                'created_at' => '2023-08-26 12:15:50',
                'updated_at' => '2023-08-26 12:15:50',
            ),
            73 => 
            array (
                'id' => 74,
                'employee_id' => 33,
                'user_id' => 9,
                'review_msg' => 'Outstanding training service that has transformed my pet\'s behavior positively. 🤩😍',
                'rating' => 4.0,
                'created_at' => '2023-08-26 12:30:40',
                'updated_at' => '2023-08-26 12:30:40',
            ),
            74 => 
            array (
                'id' => 75,
                'employee_id' => 33,
                'user_id' => 8,
                'review_msg' => 'Highly skilled trainer who brings out the best in my furry friend. 😊🥰',
                'rating' => 5.0,
                'created_at' => '2023-08-26 12:33:12',
                'updated_at' => '2023-08-26 12:33:12',
            ),
            75 => 
            array (
                'id' => 76,
                'employee_id' => 33,
                'user_id' => 7,
                'review_msg' => 'Five-star training expertise that has made a remarkable difference for us.  🤗👏',
                'rating' => 5.0,
                'created_at' => '2023-08-26 12:35:21',
                'updated_at' => '2023-08-26 12:50:52',
            ),
            76 => 
            array (
                'id' => 77,
                'employee_id' => 33,
                'user_id' => 6,
                'review_msg' => 'Reliable, patient, and effectiv - my pet\'s progress with this trainer is phenomenal. 💕😍',
                'rating' => 4.0,
                'created_at' => '2023-08-26 12:39:22',
                'updated_at' => '2023-08-26 12:39:22',
            ),
            77 => 
            array (
                'id' => 78,
                'employee_id' => 33,
                'user_id' => 2,
                'review_msg' => 'A dedicated trainer who has brought remarkable discipline and joy to my pet. 👏🥰🤩🤗',
                'rating' => 5.0,
                'created_at' => '2023-08-26 12:41:08',
                'updated_at' => '2023-08-26 12:41:08',
            ),
            78 => 
            array (
                'id' => 79,
                'employee_id' => 27,
                'user_id' => 3,
                'review_msg' => 'Five-star grooming expertise that leaves pets looking and feeling their best. 👏🥰',
                'rating' => 4.0,
                'created_at' => '2023-08-26 12:43:49',
                'updated_at' => '2023-08-26 12:43:49',
            ),
            79 => 
            array (
                'id' => 80,
                'employee_id' => 13,
                'user_id' => 4,
                'review_msg' => 'Reliable and compassionate care that provided a stress-free boarding experience. 🤗🤩',
                'rating' => 4.0,
                'created_at' => '2023-08-26 12:45:08',
                'updated_at' => '2023-08-26 12:45:08',
            ),
            80 => 
            array (
                'id' => 81,
                'employee_id' => 42,
                'user_id' => 6,
                'review_msg' => 'Reliable, attentive, and skilled in making each walk an adventure. 🥰🤗',
                'rating' => 4.0,
                'created_at' => '2023-08-26 12:49:18',
                'updated_at' => '2023-08-26 12:49:18',
            ),
        ));
        
        
    }
}