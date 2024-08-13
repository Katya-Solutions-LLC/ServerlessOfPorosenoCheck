<?php

namespace Modules\Blog\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Models\Blog;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        if (env('IS_DUMMY_DATA')) {
            $data = [
                0 => 
                array (
                    'id' => 1,
                    'name' => 'How to feed pills to dogs',
                    'description' => '<p>Giving medication to dogs can be challenging but with a few helpful tips, you can make the process more pleasant for both you and your furry friend.</p><p><strong>Pill pockets</strong>
    </p><p>Pill pockets are soft dog treats with a notch cut out to hide your pet’s medicine in. If your dog can take medication with food, try using a pill pocket or wrapping the pill in soft food like cheese. This makes it easier to slip the pill into your dog’s system. Keep in mind that this works best for dogs that quickly gobble treats without chewing. If your dog tends to chew soft treats, they might discover the medicine making it harder to administer next time. If your dog has food sensitivities or allergies, consult your veterinarian before using pill pockets.
    </p><p><strong>Compounded medications</strong>
    </p><p>Some medications come in flavoured compounded or chewable “treat” tablet forms, which can be more appealing to dogs who struggle with swallowing pills. However, these options may be more expensive, and certain medications may not be suitable for compounding due to potential effectiveness issues. Not all pharmacies compound medications, so ask your veterinarian for recommendations.</p><p><strong>Pill device</strong>
    </p><p>Administering pills to your dog can be risky as it may result in accidental bites if your fingers go near their teeth. Pill devices offer a safer alternative by allowing you to place the medication in your dog’s mouth without exposing your fingers to danger. To ensure success, place the pill behind the hump on your dog’s tongue, close their jaws, and gently stroke their throat in a downward motion to encourage swallowing.</p><p><strong>Ask for assistance</strong>
    </p><p>Trying to restrain your dog while giving them medication can be challenging. If possible, ask a friend or family member to hold your dog for you, allowing you to focus entirely on the task at hand.</p><p>Remember, the health and well-being of your dog is paramount. Always follow your veterinarian’s instructions and seek their advice if you have any concerns or questions.
    </p>',
                    'tags' => 'Animal, Care, HealthIssue',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/feedpillsdogs.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-08-29 06:54:50',
                    'updated_at' => '2023-09-13 07:06:19',
                    'deleted_at' => NULL,
                ),
                1 => 
                array (
                    'id' => 2,
                    'name' => 'How to take care of stray animals during monsoon',
                    'description' => '<p>As responsible individuals, it is our duty to care for these animals. Let’s explore some ways in which we can assist them during the monsoon season.</p><p><strong>Accommodate them at home or in your society</strong></p><p>Seek permission from the relevant authorities in your society to allow stray animals to find shelter in your apartment complex. If you live in a house, consider allocating a small dry area in your garage or a porch for them to seek refuge and stay safe from the rain.</p><p><strong>Provide temporary shelters</strong></p><p>Creating permanent animal shelters in overcrowded cities can be challenging. However, you can set up temporary shelters using tents, wood, or tin sheets in public gardens, open areas, or grounds. Ensure that the chosen location is hygienic and safe for animals, and not likely to get flooded.</p><p><strong>Arrange for food, water, and medical supplies</strong></p><p>It’s crucial to provide these animals with adequate food, water, and medical care. Encourage your community to contribute by taking turns to provide fresh food and clean water. Maintain a first-aid kit and keep a stock of essential medical supplies to treat sick animals. Use old newspapers, old clothes and sheets for the strays to curl up in, so that they can keep warm and dry. This goes a long way in helping the strays maintain their health and preventing sickness.</p><p><strong>Assist injured animals</strong> </p><p>During heavy rains, stray animals are at an increased risk of getting into accidents, and contracting fatal infections / diseases from clogged drains and stagnant water. If you come across an injured animal in distress, contact the nearest pet hospital or vet clinic for assistance.</p><p><strong>Support local animal shelters</strong></p><p>Animal shelters face additional challenges during the monsoon season. They require more food, water, and medical supplies to cater to the growing demand. Consider visiting local shelters to understand their needs and accordingly offer support. If you’re unable to provide financial assistance, you can still contribute by volunteering your time or donating items like newspapers, old clothes, bedsheets or furniture.</p><p><strong>Seek help from animal experts and NGOs</strong></p><p>In situations where you are unable to alleviate the suffering of a stray animal, reach out to the appropriate authorities. Look for animal helplines or contact nearby NGOs and animal shelters for assistance. </p><p>Let’s keep in mind that stray animals deserve the same love and care we provide to our pets. This monsoon season, let’s extend a helping hand and make a difference in their lives.
    </p>',
                    'tags' => 'StrayDog, Care, Animal',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/takecare-of-stray-animals-monsoon.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-02 06:54:50',
                    'updated_at' => '2023-09-13 07:14:04',
                    'deleted_at' => NULL,
                ),
                2 => 
                array (
                    'id' => 3,
                    'name' => 'Stray vs. Feral: What to do when you come across a feral cat',
                    'description' => '<p>Stray cats are domestic cats that have been lost or abandoned, distinguished from feral cats. Having missed out on vital socialisation, feral cats behave more like wild animals compared to gentle house cats. Here’s a ready reckoner to help you distinguish between the different types of wandering cats that surround us in our urban lives.</p><p><strong>Friendly stray</strong></p><p>Keep an eye out for collars on these amiable kitties. They may belong to a nearby neighbor or find themselves lost or abandoned, yearning for care and attention.</p><p><strong>Community cat</strong></p><p>Unlike cats with traditional owners, community cats are cared for by the community at large. While they may display a certain degree of friendliness, their level of socialisation can vary.</p><p><strong>Friendly feral</strong></p><p>Through minimal socialisation facilitated by regular feeding, friendly feral cats may exhibit some trust toward the human who provides sustenance. However, they have not reached a level of socialisation where physical touch, such as petting, is welcomed.</p><p><strong>Feral</strong></p><p>Truly feral cats lack any form of socialisation. They remain perpetually vigilant, deeply suspicious of human presence. At the first sight or sound of people, they swiftly flee.</p><p><strong>Helping feral cats in your area</strong></p><p>It is an undeniable fact that feral and stray cats endure harsh lives while navigating the perils of the outdoors. Sadly, many feral cats do not live past the age of two, a stark contrast to the extended lifespans enjoyed by indoor house cats, which can exceed 20 years. As compassionate individuals, we can take the following steps to alleviate their plight:</p><p><strong>Spay and neuter</strong></p><p>The first and most crucial step in assisting both indoor cats and free-roaming community cats is to promote and prioritise spaying and neutering. This essential measure helps control the population and prevent further suffering.</p><p><strong>Education and advocacy</strong></p><p>Educate others about the significance of spaying, neutering, and vaccinating cats. By spreading awareness, we can foster a community that actively participates in responsible pet care. Advocate for local sponsorship of low-cost spay and neuter clinics to ensure accessibility for all.</p><p><strong>Basic necessities</strong></p><p>Provide fresh, clean water to feral cats in your area. A small act like this can make a significant difference in their well-being. When feeding, offer modest portions in the mornings.</p><p><strong>Shelter initiatives</strong></p><p>Consider building a cat house or investing in an all-weather cat shelter. These shelters offer a safe haven for both stray and feral cats, protecting them from harsh weather conditions.</p><p>Seek guidance from local shelters: If you encounter a free-roaming cat or kitten and are uncertain about how best to help, reach out to your local shelter. They can provide valuable advice and support, guiding you through the process of assisting these felines effectively.</p>',
                    'tags' => 'StrayCat, FeralCat',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/stray-feral-cat.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-08-14 06:54:50',
                    'updated_at' => '2023-09-13 07:31:10',
                    'deleted_at' => NULL,
                ),
                3 => 
                array (
                    'id' => 4,
                    'name' => 'What to do when you find an injured stray animal',
                    'description' => '<p>Encountering an injured stray animal can be a distressing situation but there are steps you can take to ensure their safety and well-being. Here’s how you can best assess the situation, provide temporary care and find appropriate assistance, making a significant difference in the injured animal’s life.</p><p><strong>Assess the situation</strong></p><p>When you come across an injured animal, it’s important to assess the situation before you take any action. This will ensure your safety as well as the safety of the animal.</p><p><strong>Contact the local animal shelter</strong></p><p>If you believe the injured animal may pose an immediate threat to people or other animals, contact your local animal shelter immediately. They will have the necessary expertise and resources to handle the situation effectively.</p><p><strong>Approach with caution</strong></p><p>Approach the injured stray animal slowly and calmly, avoiding direct eye contact and sudden movements. Speak in a low, soft, reassuring tone to help calm the animal.</p><p><strong>Assess the injuries</strong></p><p>Evaluate the animal’s injuries from a safe distance. If the injuries seem severe or life-threatening, it’s best to wait for the trained professionals to arrive on the scene. Make a note of the injuries and provide this information to the authorities when they arrive. </p><p><strong>Contact local rescue organisations</strong></p><p>Reach out to local animal rescue organisations like AMTM in your area. They will provide guidance on how to proceed and may have resources to help with the care and rehabilitation of the injured stray. </p><p><strong>Stay with the animal</strong></p><p>If possible, stay with the animal until help arrives. Your presence can be comforting and reassuring to the animal during a distressing time.</p><p>Coming across an injured stray animal requires compassion and prompt action. By following these steps, you can help alleviate the fear and suffering of the animal while waiting for professional assistance. Your efforts and action can make all the difference to the animal’s chances of survival, recovery, and a brighter future.
    </p>',
                    'tags' => 'StrayDog, Injury, Care, Animal',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/injured-stray-animal.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-12 06:54:50',
                    'updated_at' => '2023-09-13 07:32:58',
                    'deleted_at' => NULL,
                ),
                4 => 
                array (
                    'id' => 5,
                    'name' => 'How to keep your pet flea and tick-free',
                    'description' => '<p>As pet owners, we want our furry friends to be happy and healthy, and part of that is keeping them safe from fleas and ticks. These tiny parasites can cause a lot of discomfort as well as transmit diseases. Fortunately, there are many ways to prevent fleas and ticks from infesting your pet. Here are some tips to help you keep your pet flea and tick-free.</p><p><strong>Use a flea and tick preventative medication</strong></p><p>There are many different types of flea and tick medications available in the market, including oral medications, topical treatments, and collars. Speak to your vet to determine which type of medication is best for your pet based on their age, weight, and overall health.</p><p><strong>Do not use canine medication for felines</strong></p><p>Don’t use flea and tick preventives meant for dogs on your cats and vice versa. Some of these products contain harmful ingredients that can cause serious reactions. The labels on these products will indicate the approved species, so make sure to use them only as directed.</p><p><strong>Groom your pet regularly</strong></p><p>Spending time grooming your pet is not only an opportunity for bonding but also a chance to check for any external parasites that might be hiding beneath their fur.</p><p>Use natural remediesThere are many natural remedies that can help to repel fleas and ticks, such as essential oils like cedarwood, lavender, and peppermint. However, be cautious when using these remedies, as some essential oils can be toxic to pets especially when they are not diluted properly or administered incorrectly. Always speak to your vet before using any natural remedies on your pet.
    </p>',
                    'tags' => 'Pet, Care, Animal, Protect',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/pet-flea-tick-free.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-08-25 06:54:50',
                    'updated_at' => '2023-09-13 07:34:49',
                    'deleted_at' => NULL,
                ),
                5 => 
                array (
                    'id' => 6,
                    'name' => 'How to Keep your Rabbits Cool in Summer',
                'description' => '<p>The summer has arrived and while many of us are enjoying the wonderful hot weather of the season, our pets may not be enjoying it quite so much.</p><p>Rabbits in particular are vulnerable to heat stroke and rely on their owners to provide them with cooler conditions during the summer months. Wild rabbits go underground or hide under shrubs and bushes to keep cool, so here we look at how, as pet owners, we can help in keeping rabbits cool in the hot weather.</p><p><strong>Offer your Rabbit Fresh, Cool Water</strong></p><p>A fresh supply of water is always essential and this should be replenished at regular intervals throughout the day during the summer months.  A combination of water bowls and bottles will give your rabbit access to plenty of liquids and you may find that they even enjoy lying in the bowls when the weather is extremely hot.</p><p>Adding ice-cubes to the water bowl will offer some cooling relief, as will offering a supply of fresh vegetables. These naturally contain a large amount of water and your rabbit will enjoy munching on them during those long hot days, whilst being kept hydrated at the same time.</p><p><strong>Keep Flies at Bay</strong></p><p>Flies are perhaps the most annoying thing about summer!  They are the most persistent of creatures that can drive us to distraction and unfortunately, they have the same effect on our rabbits.</p><p>Flies can cause serious harm if they lay eggs on your rabbit, so keeping them away from your rabbit hutch is vital.  Scrupulous hygiene is essential and only regular cleaning of your pets bedding and litter will help keep these critters away.  If you see flies around your rabbit hutch consider hanging some flypaper nearby (out of your rabbits reach) and check your pet regularly for any signs of infestation. Keeping your rabbit groomed and removing excess hair will not only help to keep them cooler in the heat, but it will also give flies less places to lay their eggs.</p><p><strong>How to Spot Heat Stroke Symptoms in Rabbits</strong></p><p>Heatstroke in rabbits can be fatal, as for other small animals. If you can spot the symptoms of heat stroke in the early stages, then you will have time to reverse the effects. The main symptoms to look out for are;
    </p><ul><li>Fast, shallow breathing
    </li><li>Wetness around the nose
    </li><li>Breathing rapidly from an open mouth whilst throwing their head back
    </li><li>Hot ears</li></ul><p>If you are worried that your rabbit has heat stroke, take them indoors and into a cool, well ventilated room immediately. Do not submerge them in cold water as this can send them into shock, but do apply a cool compress to their ears. Offer them plenty of cool, fresh water and keep them calm. If they do not appear to be getting better within a short space of time, take them to your local vet straight away.
    </p>',
                    'tags' => 'Rabbits, Care, SummerProtection',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/rabbits-cool-summer.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-04 06:54:50',
                    'updated_at' => '2023-09-13 07:38:52',
                    'deleted_at' => NULL,
                ),
                6 => 
                
                array (
                    'id' => 7,
                    'name' => 'How to Care for your Tortoise',
                    'description' => '<p>A tortoise is a wonderful pet to have, but like all exotic creatures they have specific needs and some basic requirements that must be met in order to keep them happy and healthy.</p><p>If cared for properly a tortoise will have a very long lifespan, with many living to be over 100 years old. This is why, before taking one of these delightful pets into your home, you should consider that it will most likely be a lifelong commitment and they may well outlive you!</p><p>When deciding whether or not a tortoise is right for you, you should think about where it will live, what conditions it will need and how much time and attention you will need to provide.</p><p><strong>What conditions does the tortoise need to have?</strong></p><p>As much as possible you should try to mimic the natural environment that your tortoise would have lived in. Also be aware that if the tortoise enclosure is too moist it may encourage fungal growth, which can affect their health. You should include a basking area in the enclosure, as well as some shade so that your tortoise can move around and regulate their body temperature as required.</p><p><strong>What will I need to feed my tortoise?</strong></p><p>Our range of feeding bowls have a natural effect, are easy to clean and are non-porous. They are designed to blend into the surroundings so that your tortoise will feel like it is foraging in the wild. Ensure that your tortoise always has access to shallow water for drinking and for soaking in.</p><p>The main part of your tortoises diet will be made up of fresh vegetables such as leafy greens, with some vegetation like dandelions for example. They will require protein from small live insects such as mealworms or crickets and fruit can also make up a small percentage of their diet. Calcium is particularly important to a tortoise, so be sure to add a supplement to their food twice a week.
    </p>',
                    'tags' => 'AnimalCare, Tortoise',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/care-your-tortoise.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-08-17 06:54:50',
                    'updated_at' => '2023-09-13 07:41:17',
                    'deleted_at' => NULL,
                ),
                7 => 
                array (
                    'id' => 8,
                    'name' => 'Fill Your Garden With Birds This Winter',
                    'description' => '<p>As the nights draw in and the weather gets colder, it’s not just us humans that require more to keep warm. The wildlife that commonly visits our gardens during summer gradually reduces in numbers throughout autumn and into winter, with only a few species of hardy birds staying behind. While others flee to warmer climates, many native species stick around and try to survive the harsh temperatures that the winter can bring.</p><p>But that’s not to say they don’t need our help. A recent study by the RSPB, in conjunction with 25 other wildlife organisations, has found that 60% of bird species in the UK have declined in recent years, largely due to a loss of habitat. This loss of habitat has also meant a reduced food source for birds, especially during winter where insects and bugs are scarce. And this is where we come in; by providing even a small but regular food source for our local wildlife, we could make a big difference to the future of a number of species in the UK.</p><p>No matter how large or small your outdoor space is, you can provide something for your local bird population and we’re here to offer some advice on how to do so.</p><p><strong>Plants</strong></p><p>Something that both you and the local wildlife can enjoy, plants are an easy way to provide for birds, especially if they have berries on them. A great source of food during winter, one larger bush could provide for a number of birds.</p><p><strong>Insect-Friendly Areas</strong></p><p>Insects are in short supply during winter so anything you can do to encourage them will be appreciated by birds. As well as eating insects themselves, many birds use them to feed their young and you can encourage insects with areas of long grass or even creating a log pile in one corner of your garden.</p><p><strong>Nest Boxes</strong></p><p>While most birds will be able to find their own home during the winter, or leave for warmer climes, some will stay and appreciate a warm, sheltered home. One nest box could provide a home for a mating pair and you can enjoy seeing their young when the weather improves.</p><p><strong>Bird Tables</strong></p><p>Suited to slightly larger gardens, a bird table not only provides a great feeding space for birds but it is something you can enjoy too. Looking out of your window on a cold winter’s day and seeing a selection of feeding birds is a lovely sight and you can be safe in the knowledge that you’re doing your bit.</p><p><strong>Bird Feeders</strong></p><p>If you have a smaller outdoor space, bird feeders are perfect. Suited to providing nuts and other larger feed, you’ll love seeing smaller birds hanging off throughout the winter months.</p><p><strong>Seeds &amp; Nuts</strong></p><p>Providing the right bird food during the winter will help the local population flourish. Whole nuts or larger mixes are suitable for winter as they provide a lasting food source. Black sunflower seeds are high in oil content while peanuts are a great fat source. If you don’t want added mess in your garden, husked sunflower hearts are a good choice.</p><p><strong>Fat Balls</strong></p><p>The perfect choice for the winter months, fat balls provide a great source of high quality food. Depending on how many birds visit your garden, they should last a few days at least.
    </p>',
                    'tags' => 'Birds, Feed',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/fill-your-garden-birds.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-08-23 06:54:50',
                    'updated_at' => '2023-09-13 07:43:25',
                    'deleted_at' => NULL,
                ),
                8 => 
                array (
                    'id' => 9,
                    'name' => 'Caring For Your Yemen Chameleon',
                'description' => '<p>Yemen Chameleons are one of the most attractive reptiles on the planet. Yemen Chameleons can change colour, but it isn’t always to blend in with their environment. Often the colours can represent how they’re feeling, for example brighter colours such as blue can mean the chameleon is happy in its environment, while darker colours can mean your chameleon is stressed. Although this is not always the case!</p><p>Chameleons can grow to between 14-24 inches in length, with the males being much larger than the females. By nature, most reptiles do not enjoy being handled, as they are a prey animal and can be intimidated by us as we are much larger and could be seen as a predator. However, with patience and time chameleons will tolerate being handled and enjoy your warmth. When attempting to handle your chameleon it should always be on the chameleons terms, because they can get very stressed and perceive you as a threat. Always offer your hand to the chameleon to see if it wants to be handled and don’t grab it.</p><p><strong>Diet and Food</strong></p><p>Chameleons are omnivores and will eat a variety of insect feeders. The insects range from crickets to hoppers, dubia roaches to mealworms. All insects should be gut loaded with vegetables such as carrots, greens, pepper etc. This increases the nutritional level of the insects which are passed onto your chameleon.</p><p>The insects will be sprinkled liberally with Komodo Nutrical powder or Arcadia earth pro calcium, available in store. These are to ensure all chameleons benefit from the much needed calcium intake to ensure strong bones and thus avoiding MBD (metabolic bone disease), a fatal and often easily avoided condition that causes life-long health complications for reptiles.</p><p><strong>Health and Wellbeing</strong></p><p>You should regularly health check your chameleon to ensure their eyes are bright, that they are active and maintain a good weight and condition.</p><p>You should regularly check them for stuck shed, especially around their tail and toes as this can cause further problems. Damp moss and correct humidity levels will also help the shedding process.
    </p>',
                    'tags' => 'YemenChameleon, Care',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/caring-your-yemen-chameleon.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-08 06:54:50',
                    'updated_at' => '2023-09-13 07:46:12',
                    'deleted_at' => NULL,
                ),
                9 => 
                array (
                    'id' => 10,
                    'name' => 'Caring For Your Rat',
                    'description' => '<p>Rats are wonderful pets and often get a bad reputation because of their wild cousins. Rats are extremely intelligent and often like to spend time cuddled up with their human family. With patience you can also train rats to do tricks! Rats are extremely sociable and often do best in same sex pairs.</p><p><strong>Food and Diet</strong></p><p>Our rats in store are fed on selective rat, we recommend you keep them on this food. Selective rat is a nutritionally balanced pellet food and can reduce the chances of your rat just eating the few things it likes and leaving the rest which can lead to them not getting all of the nutrients they need. At 16 weeks you can also start introducing treats and vegetables, but this should never replace the rest of their diet.</p><p>Rats are a prey animal and can be spooked when young. When handling your rat we would recommend letting them know that you’re near them by gently stroking their back and then scooping them up into your hand and placing them on your lap. Although rats can bite, it is uncommon and with time rats become extremely calm and will really enjoy spending time with you and being handled. Always supervise your rat when out of its enclosure because they are known to chew anything in their path.</p><p>Rats are a nocturnal species and are most active at dawn and dusk. They should be provided with plenty of enrichment within their enclosure to stop them from becoming bored when exploring at night.</p><p><strong>Health and Wellbeing</strong></p><p>Rats are prone to respiratory illnesses and we would recommend using bio-cat as a substrate, as it is a paper-based litter that doesn’t give off any dust. Because of this we also recommend a large barred enclosure, such as the trekker, to allow for maximum ventilation. You should regularly health check your rat to ensure their eyes are bright and alert, their nose is clear and their bottom is clean.</p><p>Rats require a lot of space to explore and keep them from being bored. If you bought an enclosure from us then you’ll be all set and ready to go. They also require a lot of toys and enrichment to keep their brains and body busy. You should move the toys around the enclosure every couple of days to keep things fresh and stimulating for them.
    </p>',
                    'tags' => 'RatCare, Animal',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/caring-rat.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-03 06:54:50',
                    'updated_at' => '2023-09-13 07:47:43',
                    'deleted_at' => NULL,
                ),
                10 => 
                array (
                    'id' => 11,
                    'name' => 'A Pet Parents Guide To Diwali!',
                    'description' => '<p>Diwali is an exciting and joyous time for everyone! However, your furry family members will require some extra care, safety, and love this time of the year.</p><p>Animals have a level of hearing and the noise and lights from bursting crackers upsets them. Here is how you can ensure a safe and happy Diwali for your pets:</p><p><strong>Soundproof your house</strong></p><p>Keep your pets strictly indoors when the fireworks are in full swing. Make sure to pull down your curtains and close all doors and windows to reduce the disturbance from fireworks. This will help pets stay calm and prevent them from escaping the house in panic.
    </p><p><strong>Walking them earlier than their usual routine can help</strong></p><p>Take them for walks in the early morning or early evenings to avoid going outside when the festive activities are at their peak on the streets.</p><p><strong>Distract your pets from the noise</strong></p><p>You can also try playing soothing music to distract them from being startled by the sudden outburst of sounds from the fireworks. Getting them a new toy might also help keep them engaged and drive their attention away from the commotion.
    </p><p><strong>Spend quality time with your pets</strong></p><p>Make this Diwali extra special for your four-legged friends by involving them in your festive celebrations by giving them some extra love, care, and love. It’s always best to spend time with your pets during stressful times as your presence will instill a sense of calm and trust in them. You can even give them some extra pet-friendly treats like peanut butter, chicken, and more to reduce their anxiety.</p><p><strong>Provide a safe space for your pets</strong></p><p>Most pets tend to seek comfort under tables, beds or chairs when they’re stressed out.</p><p>Create a comfortable corner for your pet, preferably away from doors and windows, so they can feel safe. If they already have a safe spot, you can make it more comfortable by adding a blanket and some toys.</p><p><strong>Talk to your vet about anti-anxiety medications</strong></p><p>If your pets have severe anxiety, talk to your vet and get some anti-anxiety or calming medications prescribed so you can use them if needed. It’s also good to have an emergency kit ready for your pets.</p><p>Lastly, please make sure to show some kindness and look out for stray dogs and cats in your locality. You can help them by providing food and water. If possible some shelter in your building for a day or two during Diwali so they can also feel safe and secure during the fireworks.
    </p>',
                    'tags' => 'PetCare',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/A-Pet-Parents-Guide-To-Diwali!.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:53',
                    'updated_at' => '2023-09-13 07:55:51',
                    'deleted_at' => NULL,
                ),
                11 => 
                array (
                    'id' => 12,
                    'name' => 'How does our diet impact animal welfare?',
                    'description' => '<p>Our dietary choices have far-reaching consequences both for us as well as the animals we share this planet with. It’s no secret that meat has increasingly become a central part of many people’s diets. This can be attributed to a number of factors, including population growth, economic development, and changes in cultural norms.</p><p><strong>Factory Farming: A harsh reality</strong></p><p>One of the most pressing issues related to a meat-heavy diet is the prevalence of factory farming. In order to meet the demand for meat, large-scale industrial farms have mushroomed. Unfortunately, these facilities prioritise efficiency and profit over animal welfare. Animals are often confined to tight, cramped spaces, subjected to inhumane living conditions, and deprived of basic rights. This not only compromises their well-being but also perpetuates an unsustainable system that causes immense suffering. </p><p><strong>Environmental Impact</strong></p><p>Aside from ethical concerns, a meat-forward diet also takes a toll on the environment. Animal agriculture is a major contributor to greenhouse gas emissions, deforestation, water pollution, and biodiversity loss. The resources required to raise livestock for meat production, such as land, water, and feed, put significant strain on our planet. By reducing our meat consumption, we can help alleviate these environmental pressures and move towards a more sustainable future. </p><p><strong>Health Implications</strong></p><p>Let’s not forget the impact of a meat-rich diet on our own health. While meat can be a valuable source of nutrients, excessive consumption has been linked to various health issues. High levels of saturated fats and cholesterol found in meat have been associated with heart disease, obesity, and certain types of cancer. By adopting a more balanced and plant-based diet, we can reduce the risks and improve our overall well-being. </p><p><strong>Choosing Compassion</strong></p><p>Fortunately, we have the power to make a difference. 95 “is the average number of animals spared each year by one person’s vegan diet”. Switching to a more plant-centric diet can have a positive impact on animals, the environment, and our health. By reducing our meat consumption, choosing plant-based alternatives, and supporting local and ethical farming practices, we can create a more compassionate and sustainable food system. </p><p><strong>Slow and Steady Change</strong></p><p>Changing long-established dietary habits can be challenging, but every small step counts. Start by incorporating meatless meals into your weekly routine and experimenting with new plant-based recipes. Engage in conversations and share your experiences with empathy and understanding to spread awareness about the benefits of adopting a more plant-centric diet. </p><p>As animal lovers, it’s our responsibility to acknowledge the impact of our meat-heavy diet on the lives of animals. By understanding the harsh realities of factory farming, the environmental consequences, and the potential health risks, we can make informed choices that align with our values. Let’s work together to create a world where animals are treated with compassion and respect.
    </p>',
                    'tags' => 'DietAndAnimalWelfare, EthicalEatingChoices',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/animal-welfare.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:53',
                    'updated_at' => '2023-09-13 07:58:39',
                    'deleted_at' => NULL,
                ),
                12 => 
                array (
                    'id' => 13,
                    'name' => 'Money Saving Tips For Reptile Owners',
                    'description' => '<p><strong>Use the correct thermostat</strong></p><p>It is essential to keep your enclosure at a constant temperature, recreating the environment that your pet will have lived in naturally. A thermostat can be vital in creating an ambient temperature for your pet, compatible with heat lamps, ceramic bulbs and heat mats. However, it is surprising how many owners will choose the first thermostat they come across, which can turn out to be an energy waster and therefore cost you more money in bills. You may have several thermostats when all you need is one, so research is often needed to be sure of what is required. If you can create the perfect heating system using your thermostat, you can be sure that you will be saving money in the long run.</p><p><strong>Utilise timers</strong></p><p>Sometimes your enclosure may need light or heat at different times of the day, depending on the time of year. This is where you want to be able to have full control over when your equipment is on, off or set at a higher or lower temperature. Using a timer can help you to control this output, without the need to be at home in order to change it manually and without the risk of forgetting. It will ensure that you are not wasting energy, therefore avoiding higher electricity bills.</p><p><strong>Check you are using the correct wattage</strong></p><p>First of all it is important to check the level of wattage that is needed to power all of your equipment. If you are using the wrong one, it can impact on the daily use of the item and cause it to wear out more quickly than it should. The last thing you will be wanting to do is to source a replacement. Next, see if you can get away with using a lesser wattage than you have been, as the lower the wattage, the less electricity you will be using to power it. </p><p><strong>Buy food in bulk</strong></p><p>Depending on which breed of reptile you have will depend on the type of diet that they require and how often they will need to be fed. However, buying their food in bulk should help you regardless, as long as you can keep it fresh and in a safe place. Take advantage of any money off deals that you may come across, doing a new search each time that you need to stock up.
    </p>',
                    'tags' => 'ReptileCareSavings, SmartReptileBudgeting',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/Money-Saving.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:54',
                    'updated_at' => '2023-09-13 08:00:26',
                    'deleted_at' => NULL,
                ),
                13 => 
                array (
                    'id' => 14,
                    'name' => 'High Quality Essentials For Walking Your Dog',
                    'description' => '<p><strong>Why is walking good for you and your dog?</strong></p><p>Walking is great for your cardiovascular health, helping to build up the bones and muscles in order to keep them strong. The same is true for your dog too, as they will need regular exercise to keep them fit and healthy. It will help them to stay at a healthy weight and avoid obesity. Being outside is also good for mental health. It will clear your mind, with sights and smells that will excite your dog. It’s a fun activity that you and your pet can enjoy together. </p><p><strong>Dog Collar</strong></p><p>A dog collar will not only make your pet an official member of the family, it will give you somewhere to hang an ID tag with all of your details. Even if your dog is the best behaved pooch in the world, it is always a good idea to ensure they are easy to identify, just in case they run away. A good strong dog collar will also provide you somewhere to attach some types of lead.</p><p><strong>Comfortable Harness</strong></p><p>Dog harnesses have several benefits over traditional collars and many owners who have made the change have not looked back! For dogs that pull, a harness spreads the load around the body and reduces strain on the neck and back, this is especially beneficial for small breeds and puppies. In some cases, collars can also restrict a dogs breathing, you may have heard this when walking if your dog pulls very hard. Dog harnesses are also more secure and give you more control when walking and training.</p><p><strong>Dog Lead</strong></p><p>It is important to have a quality lead for your dog as they are one of your most powerful tools when it comes to the initial training of your dog. Even once they are trained and you feel comfortable letting them run free on the beach or around a lightly wooded area, occasionally the need arises for you to re-take direct control.</p><p>Fortunately we offer a wide selection of dog leads that look great and feel comfortable in your hand; so when you’re in densely populated areas or walking along a main road, you will be able to assert additional control over your dog with exceptional ease.</p><p><strong>Poop Bag Accessories</strong></p><p>Toileting is an essential part of being a responsible dog owner; not only in terms of caring for your dog but for maintaining your local area too.</p><p>From poop scoops to dog poop bags and convenient bag dispensers, there is a whole range of products available to make cleaning up after your pets easier than ever. If you find that you are out on a walk and you don’t have any waste bags with you, one of our easy belt clip dispensers is a fantastic idea to make sure you always have a good supply to hand.
    </p>',
                    'tags' => 'TopNotchWalkiesGear, PoochPerfectionSupplies',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/High-Quality-Essentials.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:54',
                    'updated_at' => '2023-09-13 08:05:46',
                    'deleted_at' => NULL,
                ),
                14 => 
                array (
                    'id' => 15,
                    'name' => 'Slow Blinking: The Love Language of Cats',
                'description' => '<p>Have you ever wondered if your cat really loves you given their disinterested, laid back attitude? Fret not as cats have an extremely unique way of expressing themselves. While they aren’t necessarily as demonstrative as people or dogs are, cats communicate with us all the time in many different ways.</p><p>The most affectionate way of communication is through the slow blink. The slow blink is a cat’s way of saying ‘I love you.’ It’s a type of non-verbal communication through body language that shows that they are vulnerable to you, they trust you, and are comfortable around you.</p><p>This is because, in nature (out in the wild), if there’s one thing that cats would never do, it would be to close their eyes to an enemy or threat. The act of slow blinking shows they feel safe and trust you enough to relax and close their eyes for an extended period of time.</p><p>Did you know that replicating this action back to the cat has the same effect on them? If you blink slowly at your cat, they will translate it as you love them too. While it can seem silly at first, it’s very rewarding to watch and experience your cat get comfortable and blink back at you. Give it a try.</p><p>Approach your cat with relaxed eyes and a gentle stare, and slowly blink at them without speaking. Be patient and soon enough, your cat will reciprocate your love by blinking back at you!</p><p>These mysterious, fluffy creatures have many other different ways of communicating with their beloved pet parents. Some more intimate signs of affection and trust include purring, rolling down for belly rubs (exposing belly), brushing their body against yours, nuzzling, and falling asleep comfortably on or around you.</p><p>Sometimes, they groom you and other times they even bring you a nasty little meal from their hunts to show you how much they love you.
    </p>',
                    'tags' => 'CatLoveLanguage, SlowBlinkConnection',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/Slow-Blinking.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:54',
                    'updated_at' => '2023-09-13 08:06:42',
                    'deleted_at' => NULL,
                ),
                15 => 
                array (
                    'id' => 16,
                    'name' => 'Top Tips For Walking Your Dog In Autumn',
                    'description' => '<p>We are happy to say hello to autumn, where you can wrap up in knitted layers and pull on your winter boots to take your dogs on Sunday strolls across green fields, over vibrant leafy paths and in crisp misty mornings. However, with less daylight hours, and unfortunately the reality that you work 9-5, you will more often than not be walking your dog in the dark before or after work. We are here to give you the top tips on walking your dog in the autumnal months to ensure you and your dog stay safe.</p><p><strong>Invest in a glow in the dark collar or vest for your dog</strong></p><p>The Pet Express offers many products that would be suitable and they will ensure that your dog will stay safe whilst walking in the dark</p><p><strong>Carry a torch with you</strong></p><p>This simple tool will allow you to ensure you are walking on an even surface by avoiding potholes etc.</p><p><strong>Reflective tape</strong></p><p>To make sure that oncoming vehicles can see you and your dog, add reflective strips of tape onto your clothing, dog lead, and dog garments so you are fully visible.</p><p><strong>Walk against traffic</strong></p><p>This is so that there is a higher chance you see on coming traffic and increases the odds on them seeing you.</p><p><strong>Always carry a phone</strong></p><p>Make sure it’s fully charged so that you are ensuring you and your dog have the highest safety if anything were to happen.</p><p><strong>Have a tighter leash</strong></p><p>When it’s dark it is important to have your dog on a shorter lead so that they don’t wonder off as much.</p><p><strong>Autumn is an important time of year for farmers</strong></p><p>As there is a lot of livestock around it is essential to keep your dog on a lead when walking around countryside fields just in case your dogs get spooked.</p><p>Lastly, and most importantly, enjoy your autumnal walks. Whether it is on a bright sunny morning or a cool smokey evening. By following our top tips you will ensure you and your dog have the optimum safety when on your daily walks 🍂.
    </p>',
                    'tags' => 'AutumnDogWalks, SeasonalPupStrolls',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/Top-Tips-For-Walking.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:55',
                    'updated_at' => '2023-09-13 08:08:40',
                    'deleted_at' => NULL,
                ),
                16 => 
                array (
                    'id' => 17,
                    'name' => 'The Benefits & Importance of Pet Carriers',
                    'description' => '<p><strong>What are pet carriers?</strong></p><p>Pet carriers are small, portable boxes, crates, or cages that are used to transport animals like cats, lap dogs, miniature pigs, ferrets, chickens, and guinea pigs from one location to another.</p><p>You also get soft-sided carriers made of breathable fabrics. However, these provide less safety as they can be easily damaged.</p><p><strong>The importance of crate training your pet</strong></p><p>While it’s important to have carriers, it’s also equally important to train your pet to use these carriers. As a pet owner, it’s your responsibility to ensure that your pet feels safe and comfortable inside the carrier to avoid causing them stress and discomfort.</p><p>It’s better to start crate training your pet as early as possible. Sometimes it might take anywhere from days to weeks for them to get comfortable with the carrier but it’s worth the effort.</p><p><strong>They provide a safe environment, especially for puppies, kittens and rescue animals</strong></p><p>Crates are very useful in keeping your curious puppies or kittens’ little paws safe when you’re not around to supervise them. They also act as a safe place where your pets can take naps, and also help with house training them.</p><p>When it comes to rescue animals, especially those that are traumatised, a crate will act as a safe space and help them adjust to their new surroundings without having to be fearful of the changes around them.</p><p><strong>Pet carriers are a boon for transporting injured pets</strong></p><p>These carriers will make it easier for pet owners to carry their pet outside or to the vet when they’re injured. It also makes the pets feel comfortable and secure during the back and forth commute while minimising stress on their bodies.</p><p><strong>Pet carriers are an absolute necessity for pet parents that love travelling</strong></p><p>A pet carrier is one of the best ways to take your pet with you while travelling. These crates and carriers help protect your pet when you have to move from one place to another, especially if it’s by trains or air crafts. By getting your pet used to staying in a crate, you can travel together without having to constantly worry about their well-being.
    </p>',
                    'tags' => 'PetCarrierPerks, CarryThemClose',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/The_Benefits _ Importance.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:55',
                    'updated_at' => '2023-09-13 09:14:21',
                    'deleted_at' => NULL,
                ),
                17 => 
                array (
                    'id' => 18,
                    'name' => 'What to do when you find an injured or orphaned baby bird',
                    'description' => '<p>As the weather warms up, it’s common to spot young birds learning to fly on the ground. If you come across a baby bird, it’s important to know when to offer help and when to let them be</p><p><strong>Identifying nestlings and fledglings</strong></p><p>The first step is to determine whether the bird is a nestling or a fledgling. Nestlings are very young birds with few or no feathers. If you find a nestling on the ground, it needs your help to survive. Fledglings, on the other hand, are older and have a mix of fuzzy down and adult feathers. They’re often found hopping along on the ground or perching on low branches. If a fledgling appears healthy, it’s best to leave it alone.</p><p><strong>Checking the health of the bird</strong></p><p>If you find a baby bird on the ground and suspect it may be injured or ill, there are a few signs to look out for. Healthy birds will stand upright and tuck their wings tightly against their bodies. If you notice any of the following signs, offer some assistance:
    </p><ul><li>Bloody wounds or wet feathers</li><li>Legs that aren’t bearing weight</li><li>Drooping wings or highly ruffled feathers or matted feathers</li><li>Tilting of the body or head to one side</li><li>Blood around the nostrils</li><li>Cold to the touch or shivering</li><li>In an open area away from trees or bushes</li><li>Being stalked by other animals</li></ul><p>
    <strong>How to help an injured or orphaned bird</strong>
    </p><p>If you’ve identified an injured or orphaned bird, here’s what to do:
    </p><ul><li>Use clean or gloved hands to place the bird inside a cardboard box lined with paper towels and sufficient padding. Make sure this container is kept far away from potentially dangerous animals. </li><li>Use a heating pad or hot water bottle to keep the bird warm while you seek help.</li><li>Do not give the injured bird any food. Due to the shock of their injuries, they are prone to becoming hyper and can choke on the food provided to them. Giving a little water is fine, but ensure that the amount is small and not enough to choke on. </li><li>Contact your local animal protection group or forest department immediately and get help.
    </li></ul><p><strong>How to save uninjured birds</strong>
    </p><p>If you find a healthy bird that has fallen out of its nest, here’s how to help:
    </p><ul><li>Try to find the nest. If you can reach the nest, gently place the bird back inside and monitor it for a few hours.</li><li>If you can’t locate the original nest, create a new one out of a basket or container that is closest to a cereal bowl size with holes punched in the bottom. The nest should not be slippery as it can hurt the baby bird, and it should be well padded and soft. Fasten the make-shift nest to the closest sheltered area from where you found the bird - in a place where other animals cannot get to the bird. </li><li>Keep an eye on the nestling for a few hours to ensure that its parents return to feed it. If they don’t, seek help from a local animal protection group or forest department
    </li></ul>',
                    'tags' => 'BirdRescueGuide, HelpingBabyBirds',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/orphaned-baby-bird.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:55',
                    'updated_at' => '2023-09-13 09:20:03',
                    'deleted_at' => NULL,
                ),
                18 => 
                array (
                    'id' => 19,
                    'name' => 'Easy ways to help the strays beat the summer heat',
                    'description' => '<p>India’s unforgiving summer heat is already setting in, and one can only imagine with increasing dismay  how much hotter it’s going to get in the coming months. While we still have roofs over our heads and ACs to cool us down, our furry friends roaming the streets aren’t that privileged. But, there’s a lot you can do to help them and ensure that they don’t have to face the wrath of the impending summer. </p><p>Just follow these simple tips and give the strays something to cheer:            </p><p><strong>Water water everywhere to drink</strong></p><p>Animals and birds get easily dehydrated in summers. So it’s good to keep water out for them. It is best to use terracotta or mud bowls for drinking water as they keep the water cool for longer. Make sure you regularly clean and change the water to avoid contamination. Avoid adding extremely chilled water too as it may expose the animal to the risk of a heat stroke. Also remember that the water you place for the animals might dry up quickly, so refill the bowl on a regular basis.</p><p>For the birds, you can additionally hang water containers in your balcony, terrace or on trees in your garden so that they don’t have to risk their lives and come to the ground to quench their thirst. It’s also easier for them to spot water containers if they’re placed at a height. </p><p>You can also repurpose the water you use for your garden or cool the pavement to help the strays. </p><p><strong>Providing a roof over their heads</strong></p><p>It’s not uncommon to see stray dogs and cats taking shelter under a tree or in the shadow of a tall building. Please be considerate and don’t shoo them away. You can further help them by building a small shelter for them in your compound or near a shady place. </p><p>Stray shelters can’t be the same for every season. Use a grass mat as the lining and floor for the shed and use materials like cardboard and cloth for the walls of the shelter. Make sure your shelter is placed in a cool spot and is spacious so that it doesn’t trap heat. You can also add damp towels and sheets to cool them down during the afternoons, when the sun is at its peak. </p><p>Always check under your car before starting it because it’s very likely that a stray may have taken shelter under it. If you’re not mindful, you may not only cause severe burns but also  inadvertently kill an innocent animal.</p><p><strong>Pawse to pay attention</strong></p><p>Strays get paw burns by walking on the streets outside, so lookout for signs of burns and treat them the right way. Wash the injured paws using antibacterial soap and rinse thoroughly. Pat the injured foot with a clean towel to dry the area. Pour an antiseptic solution like betadine over the burned or blistered paws and allow it to dry. You can later put on soft baby socks on the burnt paws to protect them from further damage and help speed up the  healing. Take the dog to a vet if the burn is severe. </p><p>You can also purchase special powders and oils and massage your stray’s coat and paws with it. It’ll keep them cool and infections-free. </p><p><strong>Look out for them</strong> </p><p>Heat strokes during summers are as common among animals as in humans. Laboured breathing and abnormal head movements are indications of heat stroke. Pour lots of water at room temperature on the animals’ body to cool them down, wipe them with a wet towel, and contact a veterinarian immediately to save the animal’s life. 
    </p>',
                    'tags' => 'BeatTheHeatForStrays, StraySummerRescue',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/Easy-ways-to-help.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:56',
                    'updated_at' => '2023-09-13 09:23:24',
                    'deleted_at' => NULL,
                ),
                19 => 
                array (
                    'id' => 20,
                    'name' => 'The Benefits of Socialising Your Dog',
                    'description' => '<p>Socialising helps your dog understand how to react to the world in a healthy manner, while decreasing fear or aggression. It will also help your dog avoid feelings of loneliness and increase their sense of happiness and well-being, leading to a healthier, longer life.</p><p>Some of the benefits of socialising your dog include :</p><p><strong>Builds confidence &amp; a sense of secureness in your dog</strong></p><p>Socialising your dog helps in developing new and favourable behaviours. The positive reinforcement and experiences your dog receives with each new interaction will help increase their confidence and result in a well-behaved dog. These experiences can be anything from having your dog interact with the neighbours, meeting other dogs on walks, or visits to the dog park.</p><p><strong>Dogs that are socialised are less likely to run away from home</strong></p><p>A runaway pet is every pet parent’s worst nightmare. Dogs that aren’t socialised are often fearful of new environments or situations. If they escape from the house, they tend to panic and run away in desperate search of comfort and security. They are also less likely to approach strangers that try to help them.</p><p>Therefore, it’s extremely important to socialise your pets, so they adjust well to their surroundings and your neighbours. This greatly reduces their chances of running away. Positive experiences and activities like meeting new people and regular walks in the neighbourhood can ease their anxiety and prevent the worst from happening.</p><p><strong>Helps dogs easily adapt to new situations, especially a visit to the vet</strong></p><p>Socialising also helps your dog adapt to new situations with ease. This is extremely important and useful, especially if you are someone that travels a lot with your dog or you have to take your dog to the vet. Exposing them to new situations will reassure them and give them the confidence to remain calm and relaxed while visiting new and unfamiliar places, knowing that you’ve got their back.</p><p><strong>Helps improve your dog’s mental &amp; emotional health</strong></p><p>Socialisation is vital for your dog’s mental and social development. Just like humans, lack of proper socialisation can increase your dog’s chances of experiencing canine depression. This can include a decrease in their appetite and activities. It can also lead to other behavioural concerns unrelated to health issues like sleeping more often than usual, excessively licking their paws, reluctance to engage in playful activities, and more.</p><p>Therefore, it is important for your dog to learn how to make friends and interact with other animals and people. Also make sure you expose your dog to fresh air and sunshine as much as possible.</p><p><strong>Enhances their physical well-being</strong></p><p>Dogs who get plenty of quality interactions with other animals and people tend to lead healthier and happier lives. If your dog is nervous and anxious about an encounter, they will spend less time having fun and more time feeling stressed out. This is because a dog that plays a lot and is well exercised is more content and relaxed, which makes it easier for them to regulate their temperament and energy levels.
    </p>',
                    'tags' => 'SocialPaws, SocialDogAdvantage',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/The-Benefits-of-Socialising.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:56',
                    'updated_at' => '2023-09-13 09:25:12',
                    'deleted_at' => NULL,
                ),
                20 => 
                array (
                    'id' => 21,
                    'name' => 'What health risks do fleas and ticks pose for your pet?',
                    'description' => '<p>Fleas and ticks are a common problem that pet owners face, especially during the warmer months of the year. These tiny parasites feed on the blood of animals and can cause a host of problems for our furry friends as well as the humans they come in contact with. Read on to know how fleas and ticks are dangerous to pets and how you can protect your pets from them.</p><p><strong>Dangers of Fleas</strong></p><p>Fleas are not just a nuisance; they can cause severe health problems for our pets. Fleas can cause allergic reactions, dermatitis, and transmit diseases like tapeworms, murine typhus, and even the plague. In severe cases, pets that are heavily infested with fleas are at risk for developing anemia. Anemia is a condition where there are not enough red blood cells in the body and it can be life-threatening if left untreated.
    <strong>Dangers of Ticks</strong></p><p>Ticks are carriers of several diseases that can be transmitted to both pets and humans. Lyme disease is one of the most well-known diseases that ticks can transmit to pets. Lyme disease can cause joint pain, fever, and lethargy in pets, and if left untreated, it can lead to kidney failure. Other diseases that ticks can transmit include spotted fever, ehrlichiosis, and anaplasmosis.</p><p><strong>How to Protect your Pets</strong></p><p>The best way to protect your pets from fleas and ticks is to prevent infestations in the first place. There are several ways you can do this:</p><p><strong>Keep your home and yard clean</strong></p><p>Fleas can lay eggs in your home, and ticks thrive in wooded areas and long grasses. Keeping your home and yard clean can reduce the risk of infestations.</p><p><strong>Use flea and tick prevention products</strong></p><p>There are many products that can prevent fleas and ticks from infesting your pet. These products include topical treatments, flea collars, and oral medications. However, never use canine medication for felines and vice versa as they might end up poisoning your pet. To be safe, consult your vet for the best preventive treatments tailored to your pet’s requirements.</p><p><strong>Check your pets regularly </strong></p><p>Check your pets regularly for signs of fleas and ticks. This includes checking their skin, ears, and armpits. If you find a tick, remove it immediately, and keep an eye out for signs of lethargy, limping or loss of appetite. Not every tick bite causes a serious disease but it’s best to keep the vet informed just in case.</p><p><strong>Keep your pet away from heavily wooded areas and long grasses</strong></p><p>Ticks thrive in these areas, so it’s best to avoid them if possible.</p><p><strong>Regularly groom your pets</strong></p><p>Regular grooming can help remove any fleas or ticks that may be hiding in your pet’s fur.</p>',
                    'tags' => 'PetHealthAlert, GuardYourPet',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/What-health-risks.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:56',
                    'updated_at' => '2023-09-13 09:27:30',
                    'deleted_at' => NULL,
                ),
                21 => 
                array (
                    'id' => 22,
                    'name' => 'Heatstroke in Cats & How to Keep Them Safe',
                    'description' => '<p>While heatstroke in cats is not as common as it might be in dogs, there’s always a possibility that your cat can get it.</p><p>Heatstroke occurs when the cat’s body temperature rises above 104 °F, which can cause damage to internal organs and cells and can quickly lead to death. It is a life-threatening condition that needs immediate veterinary attention.</p><p>Unlike cats, dogs are capable of regulating their body temperature by panting, but cats normally don’t pant unless they’re experiencing serious illnesses, discomfort or distress.</p><p>While cats usually move to cooler places by themselves, they sometimes struggle to find a cooler place or can get stuck in enclosures, making it hard for heat to escape their body. When this happens their body won’t cool down fast enough and can lead to serious health risks.</p><p><strong>Symptoms</strong></p><p>Signs of heatstroke in cats are similar to those in dogs, however they may be more subtle. Keep a lookout for the following symptoms:</p><ul><li>Panting or rapid breathing
    </li><li>Drooling
    </li><li>Restlessness
    </li><li>Excessive grooming
    </li><li>Sweaty paws
    </li><li>Vomiting
    </li><li>High fever
    </li><li>Lethargy
    </li><li>Unresponsiveness
    </li><li>Disorientation
    </li><li>Abnormal gum color</li></ul><p><strong>Heatstroke first aid and treatment</strong></p><p>If you suspect your cat has heatstroke, take them to a vet right away. Here’s how you can help them cool down while transporting them to the vet:</p><ul><li>Make sure that your cat is in a secure container and keep the temperature cool by switching on the fan/AC or opening the windows. Place a cool towel under their body and start recording their temperature at regular intervals
    </li><li>If your cat is conscious, try to encourage them to drink a small amount of cold water as they may be dehydrated
    </li><li>Stop cooling your cat when their temperature reduces to 103.5 °F
    </li></ul><p>Please don’t ever use an ice pack or immerse your cat in ice cold water to reduce their body temperature. This can cause a sudden drop in temperature and cause your cat to go into shock.</p><p><strong>Prevention</strong></p><p>The best way to prevent heatstroke is to keep your cats inside. If your cat does go outside, make sure they have access to plenty of fresh, cold water, and shade. But even indoor cats may suffer from heat exhaustion or heatstrokes on extremely hot days, especially in homes without air conditioning. So it’s always a good idea to keep an eye on them on a regular basis.
    </p>',
                    'tags' => 'CatHeatSafety, FelineHeatCare',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/Heatstroke-in-Cats.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:57',
                    'updated_at' => '2023-09-13 09:30:41',
                    'deleted_at' => NULL,
                ),
                22 => 
                array (
                    'id' => 23,
                    'name' => 'Pet Parents Are Happier and Healthier',
                    'description' => '<p>Having a pet is an enriching experience that comes with a variety of advantages for your mental and physical health. Our pets can help us live longer, happier, and healthier lives. From reducing the risk of heart attacks to alleviating loneliness, the benefits of having pets are plentiful. Let’s talk about those benefits:</p><p><strong>Pets are excellent mood enhancers</strong></p><p>Having a pet around is extremely helpful in relieving stress. Playing with your pet can elevate levels of serotonin and dopamine, which help in making you feel calm and relaxed. Additionally, petting your animal friend, especially a cat, makes your body produce more oxytocin. Oxytocin, sometimes referred to as the “love hormone,” aids in boosting your levels of happiness.</p><p><strong>Pets are effective stress busters</strong></p><p>After a long, demanding day at work, no matter how stressed out or worn out you may feel, the joy and love you receive from your pet is sure to make you feel happy. This is because spending time and interacting with your pet is proven to reduce stress. It lowers the levels of cortisol, a stress-related hormone, and decreases blood pressure, both of which are directly linked to one’s physical and mental health. Pets are excellent stress relievers and very beneficial, especially for people suffering from anxiety or hypertension.</p><p><strong>They help ease feelings of loneliness and depression</strong></p><p>It goes without saying that having a pet can provide great companionship and make you happier. The strong bond you share with your pet not only helps reduce stress and anxiety, it also makes you feel less lonely. They help individuals fight against and recover from depression by giving their owners unconditional love.</p><p>Additionally, pets also help increase your sense of self-esteem while also boosting your mood and confidence. Moreover, dogs are extremely good at detecting when their owners are sad or depressed and will try their best to cheer you up.</p><p><strong>Pets can be great exercise buddies</strong></p><p>People with pets tend to lead a more active lifestyle compared to their no-pet counterparts. Whether it’s having a cat or a dog or any other animal, taking care of your pet - feeding, grooming, and playing or walking with them is proven to help you stay healthier.</p><p>Walking your dog regularly can help you regulate your stress and keep your cholesterol levels in check. Hence, people with dogs tend to have lower blood pressure and are less likely to develop heart disease.</p><p><strong>They give you a sense of purpose</strong></p><p>Having a pet changes your outlook on life. They give you a sense of purpose, especially when you’re going through difficulties in life. The bond with your pet provides a sense of togetherness, trust, joy and companionship.</p><p>So, if you’re considering getting a pet and are ready to enhance and improve your lifestyle with them, please visit a reputable animal shelter in your area and adopt a furry friend!
    </p>',
                    'tags' => 'HappyPetParents, HealthyPetFamilies',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/Pet-Parents-Happier.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:57',
                    'updated_at' => '2023-09-13 09:32:24',
                    'deleted_at' => NULL,
                ),
                23 => 
                array (
                    'id' => 24,
                    'name' => 'How to Reduce & Maintain Weight of Dogs with Physical Disabilities',
                    'description' => '<p>It’s important to maintain the weight and muscle mass of dogs, especially for those that have physical disabilities because they are prone to developing conditions like diabetes, heart disease, high blood pressure, cancer, joint pains, and loss of mobility.</p><p>While this is something that is not entirely preventable in most cases, there are certain ways to keep your dog healthier and happier. Here’s how you can make their life more comfortable when their mobility starts to deteriorate:</p><p><strong>Exercise and therapy</strong>
    </p><p>Regular exercise is important for all dogs, but especially so for those experiencing physical difficulties. Having an exercise regimen can help your dog maintain a healthy weight and flexibility. It also reduces their chances of being diagnosed with health issues associated with being overweight.</p><p>There are many types of exercises you can do with your dog including running, swimming (hydrotherapy), playing fetch, physical therapies, massages, indoor games like hide and seek, and more.</p><p>The most common effect of ageing for dogs is mobility loss, especially in hind legs. The best activity for your dog is determined by their current condition, age and mobility. Older dogs with arthritis might just enjoy a walk in the park or in the neighborhood. Dogs with conditions like hip or elbow dyspepsia might not be able to go hiking with you like a normal dog could; however, they can benefit the most from swimming and physical therapies.</p><p>It’s always good to make sure they get plenty of rest between their workouts so they don’t overexert their muscles. Doing this will reduce stress on their joints as well as the rest of their body.</p><p><strong>Calorie intake</strong></p><p>Calorie intake is key to reducing and maintaining weight for everyone including dogs. The amount of calorie intake depends on the dog’s body weight, activity level, and age. It should also be adjusted according to the breed and size of your dog in order to maintain their health.</p><p>Your pet will benefit most from a homemade low calorie, balanced diet with healthy ingredients like eggs, poultry, and fresh vegetables like carrots, peas, beans, broccoli, etc. It’s also great to include oils like Omega 3s and 6s, coconut oil, and more.</p><p>It’s always best to talk to a veterinarian or a pet nutritionist to determine the right intake for your pet.
    </p>',
                    'tags' => 'AdaptiveCanineWellness, WeightCareForDifferentlyAbledDogs',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/How_to_Reduce _ Maintain.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:58',
                    'updated_at' => '2023-09-13 09:33:29',
                    'deleted_at' => NULL,
                ),
                24 => 
                array (
                    'id' => 25,
                    'name' => 'The right way to feed stray animals',
                    'description' => '<p>Many people volunteer with organizations to feed stray animals but when they want to do this on their own, they are unaware of what food to feed the strays or how to give it to them.</p><p>Not to worry, we’ve got you covered.</p><p><strong>Be consistent</strong></p><p>If you’ve decided to feed the strays, make sure you’re doing it regularly. Street animals are poor at hunting, and generally live off the scraps they can find or depend on people to feed them. If you’re inconsistent, pups and kittens that have come to depend on you for food will be left to fend for themselves.</p><p><strong>Feed them in the same place every day</strong></p><p>It’s best to stick to the same spot so that the animals know exactly where to come to get fed. Additionally, sticking to the same time will also help build a routine for the animals and foster greater trust.</p><p><strong>Keep a water bowl</strong></p><p>Keep a bowl of water for the strays inside or outside your gate. Good, clean water is very important and extremely hard to come by for a stray. You can also pour them a bowl of clean water after they’re done eating. Just be sure to keep the bowl clean, and filled with room temperature water – the water bowl should not become dirty and contaminated, which will pose a risk of spreading deadly diseases.</p><p><strong>Be careful about what you feed them</strong></p><p>Generally, home-cooked food like plain rice, rotis, boiled vegetables, etc. easily suffice for pets as well as stray animals. They should not be fed spicy, sweet, deep fried, masaledar and/or salty food, as it is extremely harmful for their bodies. For older animals, cooked meat and fish are good options; you needn’t buy expensive meat, scraps like chicken feet and the like can be boiled and mixed with rice. Please do not give raw meat to pets or stray animals, and do not give cooked meat to young animals as they will not be able to digest it. For more information, check out our previous blog posts – Summer Superfoods For Your Pets, Food you should never give a dog, and What Not To Feed Cats.</p><p><strong>Feeding cows</strong></p><p>Living in India, cows are very much a stray animal nowadays. If you’re feeding cows, be careful to avoid spicy, sweet, deep fried, salty and/or masaledar food, meat, fish or eggs. But they would be happy to get any plants, fruits or vegetable remains that are generated in your house each day, such as vegetable leaves and stalks, fruits and vegetables, peels, corn and corn husks, unwanted grass and weeds, plant trimmings, etc. If you use any chemical-based pesticides or insecticides, avoid  feeding cows plant waste as it’s capable of killing them.
    </p>',
                    'tags' => 'FeedingWithCompassion, NurturingStrays',
                    'status' => 1,
                    'blog_image' => public_path('/dummy-images/blog-image/feed-stray-animals.png'),
                    'created_by' => NULL,
                    'updated_by' => 1,
                    'deleted_by' => NULL,
                    'created_at' => '2023-09-13 06:54:58',
                    'updated_at' => '2023-09-13 09:34:37',
                    'deleted_at' => NULL,
                ),
          
            ];
            foreach ($data as $key => $val) {
                // $subCategorys = $val['sub_category'];
                $blogImage = $val['blog_image'] ?? null;
                $blogData = Arr::except($val, ['blog_image']);
                $blog = Blog::create($blogData);
                
                if (isset($blogImage)) {
                    $this->attachFeatureImage($blog, $blogImage);
                    
                }
              
             
            }
        }
    }
    private function attachFeatureImage($model, $publicPath)
    {
        if(!env('IS_DUMMY_DATA_IMAGE')) return false;

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('blog_image');
        return $media;

    }
}