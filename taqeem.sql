-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 06:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taqeem`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `image`, `tags`, `content`, `created_at`) VALUES
(3, 'Discovering the Hidden Gems of Petra', 'assets/images/blogs/petra(1).jpg\r\n', 'History, Travel, Petra', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Petra, the ancient city carved into rose-red rock, is one of the most iconic archaeological sites in the world. Explore its wonders and uncover the secrets of this mysterious city.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Entrance to Petra</h2>\r\n    <p>As you enter Petra through the narrow Siq, you\'ll be greeted by the majestic view of the Treasury, one of the most impressive monuments in the ancient city.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Exploring the Lost City</h2>\r\n    <p>Wander through the ancient streets, discovering temples, tombs, and amphitheaters. Petra\'s intricate rock-cut architecture and stunning surroundings will leave you in awe.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Hiking in Petra</h2>\r\n    <p>For the adventurous, a hike to the Monastery or High Place of Sacrifice offers breathtaking views and a deeper connection to this ancient wonder.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Petra by Night</h2>\r\n    <p>Experience Petra in a whole new light as you visit the Treasury by night, illuminated by thousands of candles. It\'s a magical and unforgettable experience.</p>\r\n</div>\r\n', '2025-03-15 08:15:35'),
(4, 'A Journey Through Wadi Rum', 'assets/images/blogs/Wadi Rum(1).jpg', 'Adventure, Desert, Wadi Rum', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Wadi Rum, a vast desert valley in southern Jordan, offers breathtaking landscapes and a chance to experience the beauty of the desert like never before.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Red Sand Dunes</h2>\r\n    <p>Wadi Rum\'s striking red sand dunes create a surreal landscape. Hiking or driving through them, you\'ll feel like you\'re on another planet.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Bedouin Culture</h2>\r\n    <p>Learn about the Bedouin tribes who call Wadi Rum home. Experience their hospitality and traditional lifestyle in this incredible desert setting.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Climbing in Wadi Rum</h2>\r\n    <p>For thrill-seekers, Wadi Rum is a climber’s paradise. With towering rock formations, it’s one of the most famous climbing destinations in the world.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Wadi Rum by Night</h2>\r\n    <p>Camping under the stars in Wadi Rum is an unforgettable experience. The clear desert skies are perfect for stargazing.</p>\r\n</div>\r\n', '2025-03-15 08:15:35'),
(5, 'Exploring the Dead Sea', 'assets/images/blogs/dead sea(1).jpg', 'Wellness, Nature, Dead Sea', '<div class=\"single-blog_content--paragraph\">\r\n    <p>The Dead Sea, known for its high salt concentration and therapeutic properties, is a must-visit destination in Jordan. Here\'s what you need to know.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Healing Waters</h2>\r\n    <p>The mineral-rich waters of the Dead Sea have been used for thousands of years for their healing properties. Float in the salty water and feel the stress melt away.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Therapeutic Mud</h2>\r\n    <p>Slather yourself in the famous Dead Sea mud, known for its skin-healing benefits. Many visitors enjoy covering themselves in the black mud for a natural spa experience.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Visit the Surrounding Attractions</h2>\r\n    <p>While at the Dead Sea, explore nearby attractions such as the Baptism Site of Jesus Christ and the historical site of Mount Nebo.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Best Time to Visit</h2>\r\n    <p>The best time to visit the Dead Sea is during the cooler months, from November to March, when temperatures are more comfortable for outdoor activities.</p>\r\n</div>', '2025-03-15 08:15:35'),
(6, 'A Guide to Jerash: The Roman Ruins of Jordan', 'assets/images/blogs/Jerash(1).jpg', 'History, Culture, Jerash', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Jerash, one of the best-preserved Roman cities in the world, offers a glimpse into ancient Roman life. This guide will take you through the city’s most iconic landmarks.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Oval Plaza</h2>\r\n    <p>The heart of Jerash, the Oval Plaza, is a magnificent example of Roman architecture. Surrounded by columns, it’s the perfect place to start your exploration of the city.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Roman Theatre</h2>\r\n    <p>The Roman Theatre in Jerash is one of the city’s most iconic structures. It still hosts performances today, offering a blend of history and modern entertainment.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Temple of Artemis</h2>\r\n    <p>The Temple of Artemis, dedicated to the goddess of the hunt, is a stunning example of Roman religious architecture. The ruins offer incredible photo opportunities.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Hippodrome</h2>\r\n    <p>Visit the Hippodrome, a chariot racing stadium where you can witness reenactments of ancient Roman games and races.</p>\r\n</div>\r\n', '2025-03-15 08:15:35'),
(7, 'A Food Lover\'s Guide to Amman', 'assets/images/blogs/food.jpg', 'Food, Culture, Amman', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Amman is a culinary paradise, offering a wide range of delicious Jordanian dishes. From street food to fine dining, here’s where to eat in the capital.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Traditional Jordanian Breakfast</h2>\r\n    <p>Start your day with a traditional Jordanian breakfast of hummus, falafel, and labneh at one of Amman\'s many popular restaurants.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Street Food Adventures</h2>\r\n    <p>Explore the bustling streets of Amman and indulge in mouthwatering street food like shawarma, falafel, and fresh juices.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Dining with a View</h2>\r\n    <p>Amman offers many rooftop restaurants where you can enjoy delicious meals while taking in the stunning views of the city.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Sweet Treats</h2>\r\n    <p>End your meal with traditional Jordanian desserts like kunafa, baklava, and atayef. Pair them with a cup of mint tea for the ultimate indulgence.</p>\r\n</div>', '2025-03-15 08:15:35'),
(8, 'The Best Day Trips from Amman', 'assets/images/blogs/amman(1).jpg', 'Travel, Day Trips, Jordan', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Amman is perfectly located for day trips to some of Jordan’s most famous landmarks. From ancient ruins to natural wonders, here are the best day trips you can take from the capital.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Visit the Dead Sea</h2>\r\n    <p>Located just an hour’s drive from Amman, the Dead Sea offers a unique experience where you can float in the mineral-rich waters and enjoy a mud bath.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Explore Petra</h2>\r\n    <p>Take a day trip to Petra, one of the Seven Wonders of the World. Discover the ancient city, its rock-cut architecture, and rich history.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Discover Jerash</h2>\r\n    <p>Visit Jerash, the best-preserved Roman city in the world. Walk through ancient streets, explore the ruins, and marvel at the grandeur of the Roman Theatre.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Wadi Rum Adventure</h2>\r\n    <p>If you’re an adventure lover, a day trip to Wadi Rum will provide you with an unforgettable desert experience filled with stunning landscapes and Bedouin culture.</p>\r\n</div>', '2025-03-15 08:15:35'),
(9, 'Jordan\'s Best Kept Secrets', 'assets/images/blogs/jerash(3).jpg', 'Off the Beaten Path, Travel, Jordan', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Jordan is full of hidden gems that are often overlooked by tourists. Here are some of the best-kept secrets that will make your trip even more special.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Ajloun Castle</h2>\r\n    <p>Ajloun Castle is a stunning example of Islamic military architecture. It offers amazing views of the surrounding countryside and is perfect for history buffs.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Baptism Site</h2>\r\n    <p>Located near the Dead Sea, the Baptism Site is an important religious and historical site. It’s a peaceful and spiritual place to visit.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Al-Salt</h2>\r\n    <p>Al-Salt is a charming town with Ottoman-era buildings and a rich history. Explore the narrow streets and discover the town’s unique architecture.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Little Petra</h2>\r\n    <p>If you’re short on time, Little Petra offers a glimpse of the beauty of Petra without the crowds. It’s a peaceful and stunning location.</p>\r\n</div>', '2025-03-15 08:15:35'),
(10, 'Discovering the Magic of Kyoto', 'assets/images/blogs/Kyoto.jpg', 'Travel, Kyoto, Japan', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Kyoto, Japan\'s ancient capital, is a city steeped in history, culture, and breathtaking beauty. From the iconic Fushimi Inari Shrine to the tranquil Zen gardens, Kyoto offers a journey through the past while embracing modern-day innovations. Let\'s dive into some of the highlights that make Kyoto a must-visit destination for anyone looking to explore Japanese culture and history.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Historical Wonders</h2>\r\n    <p>The city of Kyoto is home to over 2,000 temples and shrines, making it a haven for history lovers. The Golden Pavilion (Kinkaku-ji), with its shimmering gold leaf exterior, is one of the most recognizable landmarks. The serene atmosphere surrounding the pavilion offers a peaceful retreat, allowing visitors to immerse themselves in the beauty of the architecture and nature. Another highlight is the Kiyomizu-dera Temple, which offers stunning views of the city and is known for its large wooden stage that juts out over a steep hillside. It\'s an iconic spot for capturing breathtaking photos, especially during the spring and autumn seasons when the foliage creates a vibrant backdrop.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Traditional Tea Ceremony</h2>\r\n    <p>One of the most immersive experiences in Kyoto is participating in a traditional Japanese tea ceremony. This centuries-old practice is a celebration of mindfulness, etiquette, and the beauty of simplicity. The tea ceremony is more than just drinking tea—it’s an art form that involves ritualistic movements and an appreciation for the aesthetics surrounding the tea experience. Visitors can join tea ceremonies in historic teahouses in the Higashiyama district, where they’ll be guided through the process of preparing and drinking matcha, a powdered green tea. This experience provides a deeper understanding of Japanese culture and philosophy.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Exploring Arashiyama</h2>\r\n    <p>Located on the outskirts of Kyoto, Arashiyama is a picturesque district known for its bamboo groves and tranquil landscapes. A stroll through the Bamboo Forest will leave you feeling as though you’ve stepped into a dream. The towering bamboo stalks sway gently in the breeze, creating a soothing rustling sound that enhances the peaceful atmosphere. Don\'t forget to visit the famous Togetsukyo Bridge, which spans the Katsura River and offers stunning views of the river and surrounding mountains. Arashiyama is the perfect place to unwind and reconnect with nature.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Kyoto Cuisine</h2>\r\n    <p>Kyoto is also renowned for its unique culinary offerings. The city’s cuisine is deeply influenced by its Zen Buddhist heritage, with an emphasis on vegetarian dishes made from fresh, local ingredients. Kaiseki, a traditional multi-course meal, is a must-try in Kyoto. The dishes are presented beautifully, each one crafted to highlight the flavors of the season. You’ll also find a variety of sweets, such as yatsuhashi, a traditional Kyoto treat made from rice flour, sugar, and cinnamon. Whether you\'re a food lover or just looking to try something new, Kyoto will leave you satisfied.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>Kyoto is a city that truly offers something for everyone. From its rich cultural heritage to its natural beauty and delicious food, it’s easy to see why Kyoto continues to captivate travelers from all over the world. Whether you’re visiting for the temples, the tea, or the tranquil landscapes, Kyoto is a place that will leave a lasting impression.</p>\r\n</div>', '2025-03-15 08:15:35'),
(11, 'Jordan\'s Best Kept Secrets', 'assets/images/blogs/amman(1).jpg', 'Off the Beaten Path, Travel, Jordan', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Jordan, a country known for its ancient history, stunning landscapes, and hospitable people, offers much more than the well-known sites of Petra and the Dead Sea. While these iconic landmarks are undoubtedly breathtaking, there are numerous hidden gems throughout the country that offer a more authentic and off-the-beaten-path experience. Let’s explore some of Jordan’s best-kept secrets that will make your visit even more memorable.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Wadi Rum</h2>\r\n    <p>Wadi Rum, also known as the Valley of the Moon, is a vast desert wilderness known for its dramatic sandstone mountains, narrow canyons, and awe-inspiring rock formations. This UNESCO World Heritage site is a haven for adventure seekers, offering opportunities for jeep tours, hiking, rock climbing, and stargazing under the clear desert sky. The Bedouin tribes who call Wadi Rum home offer unique experiences, such as staying in traditional desert camps and enjoying authentic meals cooked over an open fire.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Ajloun Castle</h2>\r\n    <p>Ajloun Castle is a 12th-century fortress located in the rolling hills of northern Jordan. Built by the Muslim military commander Salah ad-Din, the castle offers stunning views of the surrounding countryside and the Jordan Valley. Unlike the more crowded Petra, Ajloun remains a relatively hidden treasure, with fewer tourists and a more tranquil atmosphere. Visitors can explore the castle\'s towers, battlements, and underground chambers while learning about its fascinating history.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Dead Sea Scrolls</h2>\r\n    <p>For those interested in history and archaeology, the Dead Sea Scrolls are a must-see. Discovered in the 1940s in caves near the Dead Sea, these ancient manuscripts provide invaluable insight into the religious and cultural history of the region. The Jordan Museum in Amman displays some of these scrolls, allowing visitors to admire their preservation and learn about their significance. A visit to the museum provides a unique opportunity to connect with one of the most important archaeological finds in history.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>Jordan is a country that offers a diverse range of experiences, from historical landmarks to natural wonders. While Petra and the Dead Sea are undeniably iconic, there are many lesser-known treasures waiting to be discovered. Whether you\'re exploring the desert landscapes of Wadi Rum or the ancient ruins of Ajloun Castle, Jordan’s hidden gems will leave you with unforgettable memories.</p>\r\n</div>', '2025-03-15 08:15:35'),
(12, 'A Culinary Journey Through Italy', 'assets/images/blogs/italy.jpg', 'Food, Italy, Travel', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Italy is a country that needs no introduction when it comes to food. From pasta to pizza, gelato to espresso, Italian cuisine has captivated the hearts and palates of people around the world. But beyond the classic dishes, Italy is home to a diverse range of regional specialties that reflect its rich history and culture. Embark on a culinary journey through Italy and explore the flavors that make this country a food lover’s paradise.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Traditional Pasta Dishes</h2>\r\n    <p>No trip to Italy would be complete without indulging in its world-famous pasta dishes. In Rome, you’ll find classic recipes like cacio e pepe, a simple yet flavorful combination of pasta, pecorino cheese, and black pepper. In Bologna, the birthplace of ragù, you can savor the rich and hearty Bolognese sauce served with tagliatelle or other regional pasta shapes. Each region of Italy has its own take on pasta, offering something new and exciting for every palate.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Pizza in Naples</h2>\r\n    <p>Pizza lovers must make their way to Naples, the birthplace of the beloved pizza Margherita. Made with simple ingredients—tomato, mozzarella, basil, and olive oil—this pizza is a true representation of Italian culinary artistry. In Naples, pizzerias are a dime a dozen, but the best ones offer a thin, crispy crust and fresh ingredients that will leave you craving more. Don’t forget to try a slice of pizza margherita or a classic pizza marinara, made with just tomatoes, garlic, and olive oil.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Regional Specialties</h2>\r\n    <p>Italy’s food scene is deeply influenced by its regions, each with its own distinct flavors and ingredients. In Sicily, you can sample arancini, deep-fried rice balls stuffed with meat or cheese. In Tuscany, try the hearty ribollita soup, made with bread, beans, and vegetables, perfect for colder weather. In the Amalfi Coast, enjoy fresh seafood dishes, including spaghetti alle vongole (spaghetti with clams) and frittura di pesce (fried fish).</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Sweet Delights</h2>\r\n    <p>Italy’s desserts are just as iconic as its savory dishes. Gelato, Italy’s version of ice cream, is a must-try, with flavors ranging from classic chocolate and vanilla to innovative combinations like pistachio and ricotta. For those with a sweet tooth, try a slice of tiramisu, a decadent dessert made with layers of coffee-soaked ladyfingers, mascarpone cheese, and cocoa powder. If you’re in Sicily, be sure to sample cannoli, a pastry filled with sweet ricotta cheese and candied fruit.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>Italy’s culinary offerings are diverse, regional, and simply unforgettable. Whether you’re savoring a bowl of pasta in Rome or enjoying a slice of pizza in Naples, every bite is a celebration of Italy’s rich culture and history. So, take your time, explore the local food scene, and enjoy the flavors of Italy at their finest.</p>\r\n</div>', '2025-03-15 08:15:35'),
(13, 'Exploring Petra: The Rose City', 'assets/images/blogs/petra(2).jpg', 'Petra, History, Travel', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Petra, often referred to as the \"Rose City\" because of its stunning pink-hued stone, is one of the most iconic archaeological sites in the world. This ancient Nabatean city, carved into the red sandstone cliffs, has stood the test of time and continues to amaze visitors with its grandeur. Let\'s dive into the history and highlights of Petra, a place that should be on every traveler’s bucket list.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Treasury (Al-Khazneh)</h2>\r\n    <p>The Treasury is the most famous structure in Petra and one of the most photographed landmarks in the world. As you approach it through the narrow Siq, a dramatic canyon that leads into the heart of Petra, the sight of the Treasury suddenly emerges, revealing its magnificent façade carved directly into the rock. This ancient tomb, believed to have been built in the 1st century BC, is a testament to the incredible engineering skills of the Nabateans.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Monastery (Ad-Deir)</h2>\r\n    <p>The Monastery is another incredible site within Petra, offering panoramic views of the surrounding landscape. Though it requires a bit of a hike to reach the top, the journey is well worth it. The Monastery, with its grand façade, is larger than the Treasury and is thought to have been used as a place of worship. Visitors can marvel at the intricate carvings and enjoy a peaceful moment in this quiet corner of Petra.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>Petra’s vast historical significance and stunning natural beauty make it one of the most remarkable destinations on the planet. Whether you’re admiring the Treasury, hiking to the Monastery, or exploring the ancient tombs and caves, Petra offers a unique and unforgettable experience that should not be missed.</p>\r\n</div>', '2025-03-15 08:15:35'),
(14, 'The Dead Sea: A Unique Experience', 'assets/images/blogs/dead sea(2).jpg', 'Dead Sea, Relaxation, Travel', '<div class=\"single-blog_content--paragraph\">\r\n    <p>The Dead Sea, located at the lowest point on Earth, is a natural wonder and one of Jordan’s most famous destinations. Known for its high salt content and therapeutic properties, the Dead Sea offers visitors a chance to experience something truly unique. From floating in its mineral-rich waters to enjoying the surrounding natural beauty, here’s why the Dead Sea should be on your travel itinerary.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Floating in the Salty Waters</h2>\r\n    <p>The high salt content of the Dead Sea allows visitors to effortlessly float on its surface. This surreal experience is not only fun but also beneficial to your skin. The minerals in the water, such as magnesium, calcium, and potassium, are known for their therapeutic properties and are said to help with conditions like arthritis and skin ailments. Whether you\'re soaking in the sea or simply enjoying the view, the experience is one of a kind.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Healing Mud</h2>\r\n    <p>The mud of the Dead Sea is renowned for its healing and rejuvenating properties. Rich in minerals, the mud is often applied to the skin as a natural exfoliant. It’s a popular treatment for improving skin texture and reducing inflammation. Many resorts along the shores of the Dead Sea offer mud baths and treatments, providing visitors with a chance to indulge in some self-care while surrounded by stunning views.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>The Dead Sea is a destination like no other, offering a unique combination of relaxation, healing, and natural beauty. Whether you’re floating in its waters or indulging in a mud bath, this natural wonder will leave you feeling refreshed and rejuvenated.</p>\r\n</div>', '2025-03-15 08:15:35'),
(15, 'Wadi Rum: The Valley of the Moon', 'assets/images/blogs/Wadi Rum(2).jpg', 'Desert, Adventure, Travel', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Wadi Rum, often called the Valley of the Moon, is a vast desert wilderness located in southern Jordan. Known for its dramatic rock formations and breathtaking landscapes, Wadi Rum offers visitors an opportunity to experience the desert like never before. Whether you\'re an adventure enthusiast or simply seeking a peaceful retreat, Wadi Rum has something for everyone.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Jeep Tours and Hiking</h2>\r\n    <p>One of the best ways to explore Wadi Rum is by taking a jeep tour through the desert. These guided tours allow you to see some of the most stunning landscapes, including towering sandstone mountains, narrow canyons, and ancient petroglyphs. For the more adventurous, hiking and rock climbing are also popular activities, offering an up-close view of the desert\'s natural beauty.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Bedouin Experience</h2>\r\n    <p>Wadi Rum is home to the Bedouin people, and many visitors opt to stay in traditional Bedouin-style camps. These camps offer a unique opportunity to learn about Bedouin culture, enjoy a traditional meal, and sleep under the stars in the vast desert. The Bedouins are incredibly hospitable, and their knowledge of the desert and its history is invaluable for those looking to gain a deeper understanding of the region.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>Wadi Rum is a place of immense beauty and adventure. Whether you\'re exploring its dramatic landscapes by jeep, hiking through its mountains, or experiencing the culture of the Bedouins, Wadi Rum is sure to leave you with unforgettable memories.</p>\r\n</div>', '2025-03-15 08:15:35'),
(16, 'Amman: The Heart of Jordan', 'assets/images/blogs/amman(2).jpg', 'Amman, Culture, Travel', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Amman, the capital of Jordan, is a city that blends ancient history with modern vibrancy. With its mix of traditional markets, historical landmarks, and bustling cafes, Amman offers a unique experience that reflects the rich cultural heritage of the country. Whether you\'re a history buff or simply looking to explore a lively city, Amman has plenty to offer.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Historical Sites</h2>\r\n    <p>Amman is home to several important historical sites, including the ancient Citadel, which offers stunning views of the city and houses ruins from Roman, Byzantine, and Islamic periods. Another must-visit is the Roman Theater, an impressive structure that once hosted gladiator games and performances. These sites give visitors a glimpse into the rich history of the city and its significance in the region.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Modern Amman</h2>\r\n    <p>While Amman is steeped in history, it is also a modern and vibrant city. The downtown area is full of lively markets, trendy cafes, and art galleries. The Rainbow Street, with its colorful murals and eclectic shops, is a popular spot for both locals and tourists. Amman’s culinary scene is also booming, with a variety of restaurants offering everything from traditional Jordanian dishes to international cuisine.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>Amman is a city that effortlessly combines the old and the new. Whether you\'re exploring its historical landmarks or enjoying the vibrant atmosphere of its modern districts, Amman offers a dynamic experience that will leave you wanting more.</p>\r\n</div>', '2025-03-15 08:15:35'),
(17, 'Jerash: The Roman Ruins of Jordan', 'assets/images/blogs/Jerash(2).jpg', 'Jerash, Archaeology, Travel', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Jerash, one of the best-preserved Roman cities in the world, is a must-see destination for history enthusiasts. Located in northern Jordan, Jerash boasts stunning ruins that offer a glimpse into the grandeur of ancient Roman life. With its temples, theaters, and colonnaded streets, Jerash is a remarkable site that transports visitors back in time.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Oval Plaza</h2>\r\n    <p>The Oval Plaza is one of the most iconic features of Jerash. Surrounded by a colonnade, this large open space was used for gatherings and events in ancient times. Its impressive design and the surrounding architecture create a sense of awe, making it a favorite spot for visitors to take photos and soak in the history.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Temple of Artemis</h2>\r\n    <p>The Temple of Artemis is one of the most significant ruins in Jerash. Dedicated to the goddess of fertility and hunting, this temple was originally built in the 2nd century AD. The remains of the temple, including its columns and portico, provide insight into the grandeur of Roman religious architecture.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>Jerash is a true testament to the power and sophistication of the Roman Empire. The city’s well-preserved ruins, including the Oval Plaza, the Temple of Artemis, and the ancient theaters, offer an unparalleled look into the past. Jerash is a must-visit for anyone interested in Roman history and archaeology.</p>\r\n</div>', '2025-03-15 08:15:35'),
(18, 'The Aqaba Marine Life', 'assets/images/blogs/Aqaba(1).jpg', 'Aqaba, Marine Life, Travel', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Aqaba, Jordan’s only coastal city, offers more than just sun and sand. It is also home to some of the most vibrant marine life in the Red Sea. Whether you’re an experienced diver or a beginner snorkeler, Aqaba’s crystal-clear waters and diverse underwater ecosystems make it the perfect destination for exploring marine life.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Diving in Aqaba</h2>\r\n    <p>Aqaba is known for its incredible dive sites, which are some of the best in the Red Sea. Divers can explore colorful coral reefs, shipwrecks, and a variety of marine species, including turtles, rays, and schools of tropical fish. Popular dive sites include the Japanese Gardens and the Cedar Pride wreck, which is home to a wealth of marine life.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Snorkeling Adventures</h2>\r\n    <p>For those who prefer snorkeling, Aqaba offers numerous shallow reef areas where you can experience the beauty of the underwater world without diving deep. The calm, warm waters and vibrant marine life make snorkeling an ideal activity for families and beginners.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>Aqaba is a hidden gem for marine enthusiasts. Whether you\'re diving, snorkeling, or simply enjoying the beach, the city’s stunning marine life offers an unforgettable experience for nature lovers and adventure seekers alike.</p>\r\n</div>', '2025-03-15 08:15:35'),
(19, 'Exploring Petra: The Rose City', 'assets/images/blogs/petra(3).jpg', 'Petra, History, Travel', '<div class=\"single-blog_content--paragraph\">\r\n    <p>Petra, often referred to as the \"Rose City\" because of its stunning pink-hued stone, is one of the most iconic archaeological sites in the world. This ancient Nabatean city, carved into the red sandstone cliffs, has stood the test of time and continues to amaze visitors with its grandeur. Let\'s dive into the history and highlights of Petra, a place that should be on every traveler’s bucket list.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Treasury (Al-Khazneh)</h2>\r\n    <p>The Treasury is the most famous structure in Petra and one of the most photographed landmarks in the world. As you approach it through the narrow Siq, a dramatic canyon that leads into the heart of Petra, the sight of the Treasury suddenly emerges, revealing its magnificent façade carved directly into the rock. This ancient tomb, believed to have been built in the 1st century BC, is a testament to the incredible engineering skills of the Nabateans.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Monastery (Ad-Deir)</h2>\r\n    <p>The Monastery is another incredible site within Petra, offering panoramic views of the surrounding landscape. Though it requires a bit of a hike to reach the top, the journey is well worth it. The Monastery, with its grand façade, is larger than the Treasury and is thought to have been used as a place of worship. Visitors can marvel at the intricate carvings and enjoy a peaceful moment in this quiet corner of Petra.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>Petra’s vast historical significance and stunning natural beauty make it one of the most remarkable destinations on the planet. Whether you’re admiring the Treasury, hiking to the Monastery, or exploring the ancient tombs and caves, Petra offers a unique and unforgettable experience that should not be missed.</p>\r\n</div>', '2025-03-15 08:15:35'),
(20, 'The Dead Sea: A Unique Experience', 'assets/images/blogs/dead sea(2).jpg', 'Dead Sea, Relaxation, Travel', '<div class=\"single-blog_content--paragraph\">\r\n    <p>The Dead Sea, located at the lowest point on Earth, is a natural wonder and one of Jordan’s most famous destinations. Known for its high salt content and therapeutic properties, the Dead Sea offers visitors a chance to experience something truly unique. From floating in its mineral-rich waters to enjoying the surrounding natural beauty, here’s why the Dead Sea should be on your travel itinerary.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Floating in the Salty Waters</h2>\r\n    <p>The high salt content of the Dead Sea allows visitors to effortlessly float on its surface. This surreal experience is not only fun but also beneficial to your skin. The minerals in the water, such as magnesium, calcium, and potassium, are known for their therapeutic properties and are said to help with conditions like arthritis and skin ailments. Whether you\'re soaking in the sea or simply enjoying the view, the experience is one of a kind.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>The Healing Mud</h2>\r\n    <p>The mud of the Dead Sea is renowned for its healing and rejuvenating properties. Rich in minerals, the mud is often applied to the skin as a natural exfoliant. It’s a popular treatment for improving skin texture and reducing inflammation. Many resorts along the shores of the Dead Sea offer mud baths and treatments, providing visitors with a chance to indulge in some self-care while surrounded by stunning views.</p>\r\n</div>\r\n<div class=\"single-blog_content--paragraph\">\r\n    <h2>Final Thoughts</h2>\r\n    <p>The Dead Sea is a destination like no other, offering a unique combination of relaxation, healing, and natural beauty. Whether you’re floating in its waters or indulging in a mud bath, this natural wonder will leave you feeling refreshed and rejuvenated.</p>\r\n</div>', '2025-03-15 08:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `blog_id`, `user_id`, `comment`, `parent_comment_id`, `created_at`) VALUES
(1, 3, 1, 'Petra has always been on my bucket list! The rock-cut architecture looks absolutely stunning, and I can only imagine how breathtaking it must be in person. Has anyone visited recently? I’d love to hear about your experience, especially any tips for first-time visitors!', NULL, '2025-03-15 14:11:07'),
(2, 3, 2, 'Yes! I went last year, and it was truly a once-in-a-lifetime experience. Walking through the Siq and finally seeing the Treasury appear before my eyes was magical. I highly recommend visiting Petra by night as well. The candle-lit atmosphere creates such a mystical vibe!', 1, '2025-03-15 14:11:07'),
(3, 3, 3, 'That sounds amazing! I’ve read about the Monastery hike—how difficult was it? I’ve heard mixed reviews, with some saying it’s exhausting and others saying it’s manageable with breaks. Also, how long did it take you to reach the top?', 1, '2025-03-15 14:11:07'),
(4, 3, 2, 'It’s definitely a bit of a challenge, but totally doable if you pace yourself. The climb took me about 45 minutes to an hour, but the view from the top made every step worth it. There’s even a small café up there where you can rest and enjoy the scenery. Just bring plenty of water!', 3, '2025-03-15 14:11:07'),
(5, 3, 4, 'The entrance to Petra through the Siq looks like something out of a fantasy movie! Those towering cliffs and the anticipation of seeing the Treasury must be such an unforgettable experience. I bet it feels like stepping back in time.', NULL, '2025-03-15 14:11:07'),
(6, 3, 5, 'It really does! Fun fact: the Treasury was featured in \"Indiana Jones and the Last Crusade.\" That scene where they ride up to it made it even more legendary. But in real life, it’s even more massive and intricate than I ever imagined!', 5, '2025-03-15 14:11:07'),
(7, 3, 6, 'I wish they allowed more preservation efforts in some areas. I read that parts of the rock are eroding due to weathering and increased tourism. It’s a delicate balance between keeping it accessible and protecting such a historic site.', NULL, '2025-03-15 14:11:07'),
(8, 3, 7, 'That’s a great point. From what I saw, they are taking conservation seriously, but with the number of tourists visiting each day, it’s definitely a challenge. I think limiting access to certain fragile areas might be a good idea in the future.', 7, '2025-03-15 14:11:07'),
(9, 3, 8, 'Is Petra very crowded during peak season? I’d love to visit, but I prefer exploring places when they’re not overly packed with tourists. Are there any specific months or times of the day when it’s less crowded?', NULL, '2025-03-15 14:11:07'),
(10, 3, 9, 'Yes, it can get quite busy, especially around midday when most tour groups arrive. The best way to avoid crowds is to go early in the morning or later in the afternoon. Also, visiting in the off-season, like late autumn or early spring, helps avoid the extreme heat and peak tourist rush.', 9, '2025-03-15 14:11:07'),
(11, 7, 1, 'Amman sounds like a dream for food lovers! I’ve always wanted to try authentic Jordanian cuisine. What’s the best place for a traditional Jordanian breakfast?', NULL, '2025-03-15 14:13:24'),
(12, 7, 2, 'If you’re looking for a classic Jordanian breakfast, you have to visit Hashem Restaurant! Their hummus and falafel are legendary, and it’s a favorite among both locals and tourists.', 11, '2025-03-15 14:13:24'),
(13, 7, 3, 'I love street food! Shawarma and falafel are some of my favorites. Are there any specific places in Amman that are known for having the best street food?', NULL, '2025-03-15 14:13:24'),
(14, 18, 10, 'Aqaba sounds like an amazing destination! I’ve always wanted to go diving in the Red Sea. How difficult is it for a beginner to get started with diving there?', NULL, '2025-03-15 14:17:23'),
(15, 18, 2, 'It’s actually a great place for beginners! There are plenty of dive shops in Aqaba that offer introductory courses, and the waters are calm and clear, making it a perfect spot to learn.', 14, '2025-03-15 14:17:23'),
(16, 18, 30, 'The Japanese Gardens dive site looks stunning! Has anyone been there? I’d love to know what the experience is like and if it’s suitable for intermediate divers.', NULL, '2025-03-15 14:17:23'),
(17, 18, 19, 'Yes! I dove there last year, and it was absolutely breathtaking. The coral formations are vibrant, and there are so many colorful fish. If you’re an intermediate diver, you’ll love it—it’s not too deep, but still full of marine life.', 16, '2025-03-15 14:17:23'),
(18, 18, 24, 'Snorkeling sounds like a great option too! Are there specific locations in Aqaba that are best for snorkeling, or can you just go anywhere along the coast?', NULL, '2025-03-15 14:17:23'),
(19, 14, 12, 'The Dead Sea has always fascinated me! I’ve heard that the high salt content makes it impossible to sink, but is it safe for people with sensitive skin?', NULL, '2025-03-15 14:20:31'),
(20, 14, 16, 'Yes, it’s generally safe, but if you have any cuts or sensitive skin, the salt can cause a stinging sensation. It’s best to rinse off with fresh water after floating to avoid irritation.', 19, '2025-03-15 14:20:31'),
(21, 14, 11, 'I love the idea of a natural spa experience! Has anyone tried the Dead Sea mud treatments? Do they really help with skin conditions?', NULL, '2025-03-15 14:20:31'),
(22, 14, 26, 'I tried it last summer, and my skin felt so smooth afterward! The minerals in the mud are great for exfoliation, and it helped with some dryness I had. Definitely worth trying!', 20, '2025-03-15 14:20:31');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` enum('RESTAURANT','SHOPPING','ACTIVE_LIFE','HOME_SERVICE','COFFEE','PET','PLANT_SHOP','ART','HOTEL','EDUCATION','HEALTH','WORKSPACE') NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `icon`, `created_at`) VALUES
(1, 'RESTAURANT', 'assets/images/categories/RESTURANTS (1).jpg', 'fa-solid fa-utensils', '2025-03-15 07:52:50'),
(2, 'SHOPPING', 'assets/images/categories/SHOPPING (1).jpg', 'fa-solid fa-bag-shopping', '2025-03-15 07:52:50'),
(3, 'ACTIVE_LIFE', 'assets/images/categories/ACTIVE LIFE (1).jpg', 'fa-solid fa-person-running', '2025-03-15 07:52:50'),
(4, 'HOME_SERVICE', 'assets/images/categories/HOME SERVICES (1).jpg', 'fa-solid fa-wrench', '2025-03-15 07:52:50'),
(5, 'COFFEE', 'assets/images/categories/COFFEE (1).jpg', 'fa-solid fa-mug-saucer', '2025-03-15 07:52:50'),
(6, 'PET', 'assets/images/categories/PETS (1).jpg', 'fa-solid fa-cat', '2025-03-15 07:52:50'),
(7, 'PLANT_SHOP', 'assets/images/categories/PLANTS SHOP (1).jpg', 'fa-solid fa-seedling', '2025-03-15 07:52:50'),
(8, 'ART', 'assets/images/categories/ART (1).jpg', 'fa-solid fa-palette', '2025-03-15 07:52:50'),
(9, 'HOTEL', 'assets/images/categories/HOTELS (1).jpg', 'fa-solid fa-hotel', '2025-03-15 07:52:50'),
(10, 'EDUCATION', 'assets/images/categories/EDUCATION (1).jpg', 'fa-solid fa-graduation-cap', '2025-03-15 07:52:50'),
(11, 'HEALTH', 'assets/images/categories/HEALTH (1).jpg', 'fa-solid fa-stethoscope', '2025-03-15 07:52:50'),
(12, 'WORKSPACE', 'assets/images/categories/WORKSPACE (1).jpg', 'fa-solid fa-building', '2025-03-15 07:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `place_id`, `question`, `answer`) VALUES
(1, 1, 'What are the restaurant\'s opening hours?', 'Our restaurant is open from 9:00 AM to 10:00 PM every day. On weekends, we extend our hours until 11:00 PM.'),
(2, 1, 'Does the restaurant offer vegetarian options?', 'Yes, we have a wide variety of vegetarian dishes, including fresh salads, pasta, and plant-based burgers. Our chefs ensure that vegetarian meals are prepared separately to avoid cross-contamination.'),
(3, 1, 'Is there outdoor seating available?', 'Yes, we have a spacious outdoor patio with comfortable seating, shaded areas, and beautiful ambient lighting for evening dining.'),
(4, 3, 'What payment methods are accepted?', 'We accept cash, all major credit and debit cards, as well as mobile payments like Apple Pay and Google Pay. For large group reservations, we also offer online payment options.'),
(5, 3, 'Does the restaurant provide free Wi-Fi?', 'Yes, we offer free high-speed Wi-Fi to all customers. Simply ask our staff for the password when you arrive, and enjoy seamless browsing while you dine.'),
(6, 3, 'Can I make a reservation online?', 'Absolutely! You can book a table directly through our website or via phone. We also accept reservations for private events, and you can specify any special requests in advance.'),
(7, 5, 'Is there a kids’ menu available?', 'Yes, we offer a dedicated kids’ menu with delicious and nutritious meals, including mini burgers, pasta, and healthy fruit snacks. We also provide coloring sheets and crayons to keep kids entertained.'),
(8, 5, 'Does the restaurant have parking?', 'Yes, we provide free parking for our customers. There is a large parking lot next to the restaurant, including designated spaces for disabled parking.'),
(9, 5, 'Are there gluten-free options?', 'Yes, we cater to customers with dietary restrictions by offering a range of gluten-free options, including gluten-free bread, pasta, and desserts. Please inform our staff about any allergies before ordering.'),
(10, 10, 'What are the mall\'s operating hours?', 'Our mall is open from 10:00 AM to 10:00 PM from Monday to Thursday. On weekends (Friday to Sunday), we extend our hours until 11:30 PM.'),
(11, 10, 'Does the mall have a food court?', 'Yes, we have a large food court featuring a variety of cuisines, including fast food, international dishes, and vegetarian-friendly options.'),
(12, 10, 'Is there a play area for kids?', 'Yes, we have a dedicated indoor play area for children with fun and safe activities. There is also a supervised kids’ zone for younger visitors.'),
(13, 13, 'Does the mall offer free parking?', 'Yes, we provide free parking for visitors. The mall has a multi-level parking facility with designated areas for families and disabled guests.'),
(14, 13, 'Are there any entertainment options inside the mall?', 'Yes, our mall offers multiple entertainment options, including a cinema, an arcade, and a bowling alley. We also have a dedicated events area for live performances and seasonal attractions.'),
(15, 13, 'Can I bring my pet inside the mall?', 'Pets are allowed in designated areas of the mall. However, they must be on a leash at all times. Some stores and cafes also have pet-friendly policies.'),
(16, 15, 'Are there high-end fashion stores in the mall?', 'Yes, our mall features a range of luxury and high-end fashion brands, including designer clothing, footwear, and accessories.'),
(17, 15, 'Does the mall have wheelchair accessibility?', 'Yes, our mall is fully wheelchair accessible, with ramps, elevators, and designated seating areas. We also offer free wheelchair rentals at the customer service desk.'),
(18, 15, 'Is there a supermarket or grocery store inside the mall?', 'Yes, we have a large supermarket that offers fresh produce, household essentials, and specialty items. The supermarket also provides home delivery services for added convenience.'),
(19, 17, 'What activities are available at Climbat Amman?', 'Climbat Amman offers a variety of climbing activities, including bouldering, top-rope climbing, and lead climbing. We also provide training sessions for beginners and advanced climbers.'),
(20, 17, 'Do I need to bring my own climbing gear?', 'No, you don’t need to bring your own gear. We provide climbing shoes, harnesses, and other necessary equipment for rent. However, if you have your own gear, you are welcome to use it.'),
(21, 17, 'Is Climbat Amman suitable for beginners?', 'Yes! Climbat Amman is perfect for beginners and experienced climbers alike. Our trainers will guide you through the basics if you’re new to climbing, ensuring a safe and fun experience.'),
(22, 20, 'What are the opening hours of Amman Waves?', 'Amman Waves is open from 10:00 AM to 7:00 PM during the summer season. Hours may vary based on weather conditions, so we recommend checking our website or calling ahead.'),
(23, 20, 'Are there lifeguards on duty?', 'Yes, our trained lifeguards are always on duty to ensure the safety of all visitors. Safety is our top priority, and we follow strict guidelines for water activities.'),
(24, 20, 'Can I bring outside food and drinks?', 'Outside food and drinks are not allowed inside the park. However, we have multiple food outlets and snack bars offering a variety of meals and beverages.'),
(25, 22, 'Do I need to book in advance for Paintball Amman?', 'It is highly recommended to book in advance, especially on weekends and holidays. Walk-ins are welcome, but availability may be limited.'),
(26, 22, 'What is the minimum age requirement for paintball?', 'Participants must be at least 12 years old to play paintball. For younger players, we offer low-impact paintball sessions.'),
(27, 22, 'Is the paintball equipment provided?', 'Yes, all necessary equipment, including paintball guns, masks, and protective gear, is provided. We ensure that all gear is well-maintained and sanitized after each use.'),
(28, 24, 'What cleaning services does Quick Clean offer?', 'Quick Clean provides a variety of services, including home cleaning, office cleaning, deep cleaning, and upholstery cleaning. We also offer eco-friendly cleaning solutions.'),
(29, 24, 'Do I need to provide cleaning supplies?', 'No, our professional cleaning team brings all the necessary supplies and equipment. However, if you prefer specific products, you are welcome to provide them.'),
(30, 24, 'How can I schedule a cleaning service?', 'You can book an appointment online through our website, via phone, or through our mobile app. We offer flexible scheduling, including same-day services.'),
(31, 26, 'What smart home services does Smart Home Jordan provide?', 'We offer a wide range of smart home automation solutions, including lighting control, smart security systems, climate control, and voice-activated devices.'),
(32, 26, 'Can I integrate existing devices with your smart home system?', 'Yes! Our systems are compatible with most popular smart home devices, including Alexa, Google Home, and Apple HomeKit. We can help with setup and integration.'),
(33, 26, 'How secure are smart home automation systems?', 'Our security solutions use encrypted connections and multi-layered authentication to prevent unauthorized access. We also provide 24/7 monitoring services for added protection.'),
(34, 28, 'What moving services does Elite Movers provide?', 'Elite Movers offers local and international moving services, packing and unpacking, storage solutions, and specialized handling for fragile or valuable items.'),
(35, 28, 'Do you provide packing materials?', 'Yes, we provide high-quality packing materials, including boxes, bubble wrap, and protective padding, to ensure the safety of your belongings during transit.'),
(36, 28, 'How far in advance should I book a moving service?', 'We recommend booking at least 2-3 weeks in advance for local moves and at least a month in advance for international relocations. However, we also offer last-minute moving services based on availability.'),
(37, 36, 'What types of coffee do you serve?', 'We serve a variety of coffees, including espresso, cappuccino, latte, cold brew, and specialty drinks. We also offer decaf and dairy-free alternatives.'),
(38, 36, 'Do you have any non-coffee drinks?', 'Yes! In addition to coffee, we offer a selection of teas, fresh juices, smoothies, and hot chocolate.'),
(39, 36, 'Is there free Wi-Fi available?', 'Yes, we offer free Wi-Fi to all customers. Just ask our staff for the password and enjoy a comfortable workspace with your coffee.'),
(40, 37, 'Do you offer any pastries or snacks?', 'Yes, we have a delicious selection of pastries, cakes, and sandwiches that pair perfectly with our coffee. Our menu includes vegan and gluten-free options.'),
(41, 37, 'Can I bring my laptop and work from the café?', 'Absolutely! We welcome remote workers and students. We have plenty of seating, free Wi-Fi, and power outlets available.'),
(42, 37, 'Do you have outdoor seating?', 'Yes, we have a cozy outdoor seating area where you can enjoy your coffee in the fresh air.'),
(43, 42, 'Do you offer takeaway and delivery?', 'Yes! You can order takeaway at our café or place a delivery order through our partnered apps like Talabat and Careem.'),
(44, 42, 'Do you have loyalty or rewards programs?', 'Yes, we offer a loyalty program where you earn points with every purchase. Redeem your points for free drinks, discounts, and special offers.'),
(45, 42, 'Are there dairy-free or alternative milk options?', 'Yes! We offer almond, soy, oat, and coconut milk as alternatives to dairy in all our drinks.'),
(46, 50, 'What types of pets do you sell?', 'We offer a variety of pets, including dogs, cats, birds, fish, and small animals like rabbits and hamsters. We also provide adoption options for rescued pets.'),
(47, 50, 'Do you sell pet food and accessories?', 'Yes, we have a wide selection of pet food, treats, toys, grooming supplies, beds, and other accessories for all types of pets.'),
(48, 50, 'Can I bring my pet to the store?', 'Absolutely! We welcome pets in our store. Bring your furry friend along to shop for their favorite products.'),
(49, 52, 'Do you offer pet grooming services?', 'Yes, we provide professional grooming services, including baths, haircuts, nail trimming, and ear cleaning. Appointments can be booked online or in-store.'),
(50, 52, 'Do you have veterinary services available?', 'Yes, we have an in-store veterinary clinic that offers check-ups, vaccinations, and general pet healthcare.'),
(51, 52, 'Can I return or exchange pet products?', 'We accept returns and exchanges within 14 days of purchase, as long as the product is unused and in its original packaging. Perishable items and opened food bags are non-returnable.'),
(52, 54, 'Do you offer pet adoption services?', 'Yes! We partner with local animal shelters to help find loving homes for pets in need. Visit our adoption section to see available pets.'),
(53, 54, 'What are your store hours?', 'We are open daily from 10:00 AM to 9:00 PM. Hours may vary on holidays, so check our website for updates.'),
(54, 54, 'Do you have loyalty programs for regular customers?', 'Yes, our loyalty program allows you to earn points on every purchase. Redeem points for discounts, free products, and special promotions.'),
(55, 68, 'What type of art supplies do you sell?', 'We offer a variety of art materials, including paints, brushes, sketchbooks, canvases, and digital art tools.'),
(56, 68, 'Do you sell original artwork?', 'Yes! We feature local artists and sell original paintings, sculptures, and handmade crafts.'),
(57, 68, 'Can I take an art workshop at your store?', 'Yes! We host regular workshops on painting, drawing, and other creative skills. Check our schedule for upcoming events.'),
(58, 70, 'Do you offer custom framing services?', 'Yes, we provide professional framing services for paintings, photos, and prints. Choose from a variety of frames and sizes.'),
(59, 70, 'Are gift cards available?', 'Yes, we offer gift cards that can be used for art supplies or artwork. They make a perfect gift for art lovers.'),
(60, 70, 'Do you have a loyalty program for frequent shoppers?', 'Yes! Earn points with every purchase and redeem them for discounts on future buys.'),
(61, 72, 'Can I return or exchange art supplies?', 'Yes, we accept returns within 14 days for unused and unopened items with a receipt.'),
(62, 72, 'Do you support local artists?', 'Absolutely! We provide a space for local artists to showcase and sell their work.'),
(63, 72, 'Do you offer discounts for students?', 'Yes, students and art professionals can get special discounts on supplies with a valid ID.'),
(64, 74, 'What amenities does your hotel offer?', 'We provide free Wi-Fi, a swimming pool, a gym, a restaurant, and 24/7 room service for a comfortable stay.'),
(65, 74, 'Do you offer airport transportation?', 'Yes, we provide shuttle services to and from the airport upon request.'),
(66, 74, 'Can I request an early check-in or late check-out?', 'Yes, early check-in and late check-out are available based on room availability. Additional fees may apply.'),
(67, 76, 'Do you have family-friendly rooms?', 'Yes, we have family suites with extra beds and child-friendly amenities.'),
(68, 76, 'Is breakfast included in the booking?', 'Yes, we offer complimentary breakfast with most room bookings.'),
(69, 76, 'Do you allow pets in the hotel?', 'Some of our rooms are pet-friendly. Please contact us in advance to check availability.'),
(70, 78, 'What is your cancellation policy?', 'You can cancel for free up to 24 hours before check-in. Late cancellations may incur charges.'),
(71, 78, 'Do you have event or conference rooms?', 'Yes, we have meeting rooms and banquet halls available for events, conferences, and weddings.'),
(72, 78, 'Is there parking available at the hotel?', 'Yes, we provide free parking for guests staying at the hotel.'),
(73, 92, 'What programs and degrees do you offer?', 'We offer undergraduate and postgraduate programs in various fields, including engineering, business, and arts.'),
(74, 92, 'How can I apply for admission?', 'You can apply online through our website or visit our admissions office for guidance.'),
(75, 92, 'Do you offer scholarships?', 'Yes, we provide merit-based and need-based scholarships for eligible students.'),
(76, 94, 'Are there student dormitories available?', 'Yes, we offer on-campus housing for students with various accommodation options.'),
(77, 94, 'Do you have extracurricular activities?', 'Yes! We have sports teams, student clubs, and cultural events throughout the year.'),
(78, 94, 'Is there a career center to help students find jobs?', 'Yes, our career center offers internship opportunities, resume-building workshops, and job placement support.'),
(79, 96, 'What are the tuition fees?', 'Tuition fees vary by program. Visit our website or contact our admissions office for detailed information.'),
(80, 96, 'Do you have online or evening classes?', 'Yes, we offer flexible learning options, including online and evening courses for working students.'),
(81, 96, 'Is there a library and study spaces?', 'Yes, we have a large library with study areas, research resources, and digital access to academic journals.'),
(82, 104, 'What medical services do you provide?', 'We offer general healthcare, emergency services, specialist consultations, surgeries, and diagnostic tests.'),
(83, 104, 'Do you have 24/7 emergency services?', 'Yes, our emergency department is open 24/7 with on-call doctors and nurses.'),
(84, 104, 'Can I book an appointment online?', 'Yes, you can schedule appointments through our website or by calling our reception desk.'),
(85, 106, 'Do you accept health insurance?', 'Yes, we accept most major health insurance plans. Contact us for specific details.'),
(86, 106, 'Are there maternity and pediatric services?', 'Yes, we have a dedicated maternity ward and pediatric specialists for children’s healthcare.'),
(87, 106, 'Do you provide home healthcare services?', 'Yes, we offer home nursing and medical consultations for patients who need care at home.'),
(88, 108, 'How do I get my medical records?', 'You can request your medical records by visiting our records department or through our online patient portal.'),
(89, 108, 'Do you have a pharmacy on-site?', 'Yes, we have a fully stocked pharmacy within the hospital for your convenience.'),
(90, 108, 'What safety measures are in place for COVID-19?', 'We follow strict hygiene and safety protocols, including sanitization, temperature checks, and social distancing.'),
(91, 120, 'What types of workspaces do you offer?', 'We offer private offices, shared coworking spaces, and meeting rooms for freelancers, startups, and businesses.'),
(92, 120, 'Do you provide high-speed internet?', 'Yes, all our workspaces come with high-speed Wi-Fi and Ethernet connections.'),
(93, 120, 'Can I book a meeting room?', 'Yes, you can book a fully-equipped meeting room by the hour or day through our website.'),
(94, 121, 'Do you offer daily and monthly memberships?', 'Yes, we have flexible membership plans ranging from daily passes to monthly subscriptions.'),
(95, 121, 'Are there printing and office supplies available?', 'Yes, we provide printers, scanners, and office supplies for our members.'),
(96, 121, 'Is there a café or kitchen area?', 'Yes, we have a kitchen with complimentary coffee, tea, and snacks.'),
(97, 122, 'Can I access the workspace 24/7?', 'Yes, members with certain plans have 24/7 access to the coworking space.'),
(98, 122, 'Do you have networking events or workshops?', 'Yes, we host regular networking events, skill-building workshops, and guest speaker sessions.'),
(99, 122, 'Is parking available for workspace members?', 'Yes, we provide on-site or nearby parking for our members.');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `place_id`, `name`, `price`, `description`, `image`) VALUES
(1, 1, 'Grilled Chicken', 12.99, 'Tender and juicy grilled chicken breast marinated in aromatic herbs and served with a side of roasted vegetables and garlic butter sauce.', 'assets/images/places/restaurants/R(1).jpg'),
(2, 1, 'Pasta Alfredo', 10.99, 'A creamy Alfredo pasta dish made with rich Parmesan cheese, fresh cream, and topped with grilled chicken or shrimp for an extra indulgence.', 'assets/images/places/restaurants/R(2).jpg'),
(3, 1, 'Caesar Salad', 8.99, 'Crisp romaine lettuce tossed with homemade Caesar dressing, garlic croutons, and shaved Parmesan cheese, served with a lemon wedge.', 'assets/images/places/restaurants/R(3).jpg'),
(4, 1, 'Cheeseburger', 11.49, 'A classic cheeseburger featuring a thick and juicy beef patty, melted cheddar cheese, crisp lettuce, and ripe tomatoes on a toasted brioche bun.', 'assets/images/places/restaurants/R(4).jpg'),
(5, 2, 'Sushi Roll', 14.99, 'A beautifully crafted sushi roll filled with fresh salmon, avocado, and cucumber, wrapped in seaweed and rice, served with soy sauce and wasabi.', 'assets/images/places/restaurants/R(5).jpg'),
(6, 2, 'Miso Soup', 4.99, 'A warm and comforting Japanese soup made with miso paste, tofu cubes, green onions, and seaweed, perfect as a light appetizer.', 'assets/images/places/restaurants/R(6).jpg'),
(7, 2, 'Tempura Shrimp', 9.99, 'Crispy golden-battered shrimp, deep-fried to perfection and served with a sweet and savory tempura dipping sauce.', 'assets/images/places/restaurants/R(7).jpg'),
(8, 2, 'Beef Teriyaki', 16.99, 'Grilled slices of tender beef glazed with a rich and flavorful teriyaki sauce, served with a side of steamed rice and stir-fried vegetables.', 'assets/images/places/restaurants/R(8).jpg'),
(9, 2, 'Green Tea Ice Cream', 5.99, 'A refreshing and creamy green tea-flavored ice cream with a subtle earthy sweetness, served with a drizzle of honey.', 'assets/images/places/restaurants/R(9).jpg'),
(10, 2, 'Ramen Bowl', 12.99, 'A steaming bowl of traditional ramen noodles in a rich miso broth, topped with tender slices of pork, soft-boiled egg, and green onions.', 'assets/images/places/restaurants/R(10).jpg'),
(11, 3, 'Steak Frites', 18.99, 'A French bistro classic featuring a juicy, grilled steak paired with golden crispy French fries and served with a side of creamy peppercorn sauce.', 'assets/images/places/restaurants/R(11).jpg'),
(12, 3, 'French Onion Soup', 6.99, 'A deeply flavorful caramelized onion soup topped with a layer of melted Gruyère cheese and served with a crispy baguette.', 'assets/images/places/restaurants/R(12).jpg'),
(13, 3, 'Croissant', 3.99, 'A buttery and flaky French pastry with a golden, crispy exterior and a soft, airy interior, perfect for breakfast or a light snack.', 'assets/images/places/restaurants/R(13).jpg'),
(14, 3, 'Coq au Vin', 17.99, 'A classic French dish featuring tender chicken slow-cooked in a rich red wine sauce with mushrooms, onions, and fresh herbs.', 'assets/images/places/restaurants/R(14).jpg'),
(15, 3, 'Crème Brûlée', 8.99, 'A creamy vanilla custard dessert topped with a caramelized sugar crust that cracks with every spoonful.', 'assets/images/places/restaurants/R(15).jpg'),
(16, 3, 'Duck Confit', 19.99, 'Slow-cooked duck leg, perfectly crispy on the outside and tender on the inside, served with a side of roasted potatoes.', 'assets/images/places/restaurants/R(16).jpg'),
(17, 4, 'Pepperoni Pizza', 14.99, 'A deliciously cheesy pizza topped with crispy pepperoni slices, a tangy tomato sauce, and a perfectly baked golden crust.', 'assets/images/places/restaurants/R(17).jpg'),
(18, 4, 'Garlic Bread', 4.99, 'Warm and crispy garlic bread topped with melted butter, minced garlic, and fresh parsley, perfect as a side dish.', 'assets/images/places/restaurants/R(18).jpg'),
(19, 4, 'Chicken Wings', 9.99, 'Crispy, golden chicken wings tossed in your choice of buffalo, BBQ, or honey garlic sauce, served with ranch or blue cheese dip.', 'assets/images/places/restaurants/R(19).jpg'),
(20, 4, 'Mozzarella Sticks', 7.99, 'Crispy fried mozzarella cheese sticks served with a side of tangy marinara sauce for dipping.', 'assets/images/places/restaurants/R(20).jpg'),
(21, 4, 'Chocolate Lava Cake', 6.99, 'A decadent chocolate cake with a warm, gooey molten chocolate center, served with a scoop of vanilla ice cream.', 'assets/images/places/restaurants/R(1).jpg'),
(22, 4, 'BBQ Ribs', 21.99, 'Slow-cooked, fall-off-the-bone pork ribs glazed in a smoky barbecue sauce, served with a side of coleslaw.', 'assets/images/places/restaurants/R(2).jpg'),
(23, 5, 'Tacos al Pastor', 9.99, 'Delicious corn tortillas filled with marinated pork, pineapple, onions, and fresh cilantro, served with a side of tangy salsa.', 'assets/images/places/restaurants/R(21).jpg'),
(24, 5, 'Guacamole & Chips', 6.99, 'Freshly made guacamole with ripe avocados, lime, diced tomatoes, and cilantro, served with crispy tortilla chips.', 'assets/images/places/restaurants/R(22).jpg'),
(25, 5, 'Enchiladas Verdes', 11.99, 'Soft corn tortillas stuffed with shredded chicken, covered in a tangy green tomatillo sauce, and topped with melted cheese.', 'assets/images/places/restaurants/R(23).jpg'),
(26, 5, 'Churros', 5.99, 'Crispy, golden-fried pastries coated in cinnamon sugar, served with warm chocolate dipping sauce.', 'assets/images/places/restaurants/R(24).jpg'),
(27, 5, 'Carne Asada', 14.99, 'Grilled marinated beef served with a side of rice, beans, and fresh salsa, perfect for a hearty meal.', 'assets/images/places/restaurants/R(25).jpg'),
(28, 5, 'Mexican Street Corn', 4.99, 'Grilled corn on the cob slathered with mayonnaise, cheese, chili powder, and fresh lime juice for a true taste of Mexico.', 'assets/images/places/restaurants/R(26).jpg'),
(29, 6, 'Margherita Pizza', 12.99, 'A classic Italian pizza topped with fresh tomatoes, mozzarella cheese, basil, and a drizzle of olive oil.', 'assets/images/places/restaurants/R(27).jpg'),
(30, 6, 'Lasagna', 14.99, 'Layers of pasta, ricotta cheese, and marinara sauce, baked to perfection with a golden, bubbly top.', 'assets/images/places/restaurants/R(28).jpg'),
(31, 6, 'Bruschetta', 6.99, 'Grilled bread topped with a mixture of diced tomatoes, garlic, basil, and balsamic vinegar for a fresh, light appetizer.', 'assets/images/places/restaurants/R(29).jpg'),
(32, 6, 'Fettuccine Alfredo', 13.99, 'Rich and creamy Alfredo sauce served with fettuccine noodles, topped with Parmesan cheese and grilled chicken or shrimp.', 'assets/images/places/restaurants/R(30).jpg'),
(33, 6, 'Tiramisu', 6.99, 'A rich and indulgent Italian dessert made with layers of coffee-soaked ladyfingers, mascarpone cream, and cocoa powder.', 'assets/images/places/restaurants/R(31).jpg'),
(34, 6, 'Caprese Salad', 8.99, 'Fresh mozzarella, tomatoes, and basil drizzled with olive oil and balsamic vinegar, a light and flavorful dish.', 'assets/images/places/restaurants/R(32).jpg'),
(35, 7, 'Grilled Salmon', 18.99, 'Fresh, grilled salmon fillet served with a side of lemon-butter sauce and roasted vegetables.', 'assets/images/places/restaurants/R(33).jpg'),
(36, 7, 'Fish Tacos', 9.99, 'Crispy fried fish served in soft tortillas with cabbage slaw, avocado, and a creamy sauce.', 'assets/images/places/restaurants/R(34).jpg'),
(37, 7, 'Clam Chowder', 7.99, 'A creamy soup made with fresh clams, potatoes, celery, and onions, served in a bread bowl for a unique experience.', 'assets/images/places/restaurants/R(35).jpg'),
(38, 7, 'Lobster Roll', 22.99, 'A fresh lobster salad with mayonnaise, celery, and lemon served in a buttered and toasted roll.', 'assets/images/places/restaurants/R(36).jpg'),
(39, 7, 'Shrimp Scampi', 15.99, 'Succulent shrimp sautéed in garlic butter and white wine, served over a bed of linguine pasta.', 'assets/images/places/restaurants/R(37).jpg'),
(40, 7, 'Crab Cakes', 13.99, 'Golden-fried crab cakes filled with tender crab meat, herbs, and spices, served with a tangy remoulade sauce.', 'assets/images/places/restaurants/R(38).jpg'),
(41, 8, 'Dim Sum', 11.99, 'A variety of steamed dumplings and buns filled with pork, shrimp, and vegetables, served with soy sauce.', 'assets/images/places/restaurants/R(39).jpg'),
(42, 8, 'Kung Pao Chicken', 12.99, 'Stir-fried chicken with peanuts, chili peppers, and a flavorful kung pao sauce, served with steamed rice.', 'assets/images/places/restaurants/R(40).jpg'),
(43, 8, 'Sushi Platter', 18.99, 'A beautiful assortment of fresh sushi, including nigiri, sashimi, and rolls, served with soy sauce, wasabi, and pickled ginger.', 'assets/images/places/restaurants/R(41).jpg'),
(44, 8, 'Beef and Broccoli', 13.99, 'Tender slices of beef stir-fried with fresh broccoli in a savory soy-based sauce.', 'assets/images/places/restaurants/R(42).jpg'),
(45, 8, 'Sweet and Sour Pork', 14.99, 'Crispy battered pork chunks tossed in a tangy sweet and sour sauce with pineapple and bell peppers.', 'assets/images/places/restaurants/R(43).jpg'),
(46, 8, 'Miso Ramen', 12.99, 'A comforting bowl of ramen noodles in a rich miso broth, topped with pork, soft-boiled egg, bamboo shoots, and green onions.', 'assets/images/places/restaurants/R(44).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `opening_hours`
--

CREATE TABLE `opening_hours` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opening_hours`
--

INSERT INTO `opening_hours` (`id`, `place_id`, `day`, `open_time`, `close_time`) VALUES
(1024, 1, 'Monday', '10:00:00', '11:00:00'),
(1025, 1, 'Tuesday', '10:00:00', '11:00:00'),
(1026, 1, 'Wednesday', '10:00:00', '11:00:00'),
(1027, 1, 'Thursday', '10:00:00', '11:00:00'),
(1028, 1, 'Friday', '10:00:00', '11:00:00'),
(1029, 1, 'Saturday', '10:00:00', '11:00:00'),
(1030, 1, 'Sunday', '10:00:00', '11:00:00'),
(1031, 6, 'Monday', '10:00:00', '11:00:00'),
(1032, 6, 'Tuesday', '10:00:00', '11:00:00'),
(1033, 6, 'Wednesday', '10:00:00', '11:00:00'),
(1034, 6, 'Thursday', '10:00:00', '11:00:00'),
(1035, 6, 'Friday', '10:00:00', '11:00:00'),
(1036, 6, 'Saturday', '10:00:00', '11:00:00'),
(1037, 6, 'Sunday', '10:00:00', '11:00:00'),
(1038, 11, 'Monday', '10:00:00', '11:00:00'),
(1039, 11, 'Tuesday', '10:00:00', '11:00:00'),
(1040, 11, 'Wednesday', '10:00:00', '11:00:00'),
(1041, 11, 'Thursday', '10:00:00', '11:00:00'),
(1042, 11, 'Friday', '10:00:00', '11:00:00'),
(1043, 11, 'Saturday', '10:00:00', '11:00:00'),
(1044, 11, 'Sunday', '10:00:00', '11:00:00'),
(1045, 16, 'Monday', '10:00:00', '11:00:00'),
(1046, 16, 'Tuesday', '10:00:00', '11:00:00'),
(1047, 16, 'Wednesday', '10:00:00', '11:00:00'),
(1048, 16, 'Thursday', '10:00:00', '11:00:00'),
(1049, 16, 'Friday', '10:00:00', '11:00:00'),
(1050, 16, 'Saturday', '10:00:00', '11:00:00'),
(1051, 16, 'Sunday', '10:00:00', '11:00:00'),
(1052, 21, 'Monday', '10:00:00', '11:00:00'),
(1053, 21, 'Tuesday', '10:00:00', '11:00:00'),
(1054, 21, 'Wednesday', '10:00:00', '11:00:00'),
(1055, 21, 'Thursday', '10:00:00', '11:00:00'),
(1056, 21, 'Friday', '10:00:00', '11:00:00'),
(1057, 21, 'Saturday', '10:00:00', '11:00:00'),
(1058, 21, 'Sunday', '10:00:00', '11:00:00'),
(1059, 26, 'Monday', '10:00:00', '11:00:00'),
(1060, 26, 'Tuesday', '10:00:00', '11:00:00'),
(1061, 26, 'Wednesday', '10:00:00', '11:00:00'),
(1062, 26, 'Thursday', '10:00:00', '11:00:00'),
(1063, 26, 'Friday', '10:00:00', '11:00:00'),
(1064, 26, 'Saturday', '10:00:00', '11:00:00'),
(1065, 26, 'Sunday', '10:00:00', '11:00:00'),
(1066, 31, 'Monday', '10:00:00', '11:00:00'),
(1067, 31, 'Tuesday', '10:00:00', '11:00:00'),
(1068, 31, 'Wednesday', '10:00:00', '11:00:00'),
(1069, 31, 'Thursday', '10:00:00', '11:00:00'),
(1070, 31, 'Friday', '10:00:00', '11:00:00'),
(1071, 31, 'Saturday', '10:00:00', '11:00:00'),
(1072, 31, 'Sunday', '10:00:00', '11:00:00'),
(1073, 36, 'Monday', '10:00:00', '11:00:00'),
(1074, 36, 'Tuesday', '10:00:00', '11:00:00'),
(1075, 36, 'Wednesday', '10:00:00', '11:00:00'),
(1076, 36, 'Thursday', '10:00:00', '11:00:00'),
(1077, 36, 'Friday', '10:00:00', '11:00:00'),
(1078, 36, 'Saturday', '10:00:00', '11:00:00'),
(1079, 36, 'Sunday', '10:00:00', '11:00:00'),
(1080, 41, 'Monday', '10:00:00', '11:00:00'),
(1081, 41, 'Tuesday', '10:00:00', '11:00:00'),
(1082, 41, 'Wednesday', '10:00:00', '11:00:00'),
(1083, 41, 'Thursday', '10:00:00', '11:00:00'),
(1084, 41, 'Friday', '10:00:00', '11:00:00'),
(1085, 41, 'Saturday', '10:00:00', '11:00:00'),
(1086, 41, 'Sunday', '10:00:00', '11:00:00'),
(1087, 46, 'Monday', '10:00:00', '11:00:00'),
(1088, 46, 'Tuesday', '10:00:00', '11:00:00'),
(1089, 46, 'Wednesday', '10:00:00', '11:00:00'),
(1090, 46, 'Thursday', '10:00:00', '11:00:00'),
(1091, 46, 'Friday', '10:00:00', '11:00:00'),
(1092, 46, 'Saturday', '10:00:00', '11:00:00'),
(1093, 46, 'Sunday', '10:00:00', '11:00:00'),
(1094, 51, 'Monday', '10:00:00', '11:00:00'),
(1095, 51, 'Tuesday', '10:00:00', '11:00:00'),
(1096, 51, 'Wednesday', '10:00:00', '11:00:00'),
(1097, 51, 'Thursday', '10:00:00', '11:00:00'),
(1098, 51, 'Friday', '10:00:00', '11:00:00'),
(1099, 51, 'Saturday', '10:00:00', '11:00:00'),
(1100, 51, 'Sunday', '10:00:00', '11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` enum('$','$$','$$$') NOT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `highlights` text DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `google_map_location` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_1` varchar(20) DEFAULT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `user_id`, `category_id`, `name`, `price`, `tags`, `highlights`, `country`, `city`, `google_map_location`, `email`, `phone_1`, `phone_2`, `website`, `facebook_url`, `instagram_url`, `twitter_url`, `featured_image`, `created_at`) VALUES
(1, 1, 1, 'Zarb House', '$$$', 'Jordanian, BBQ, Traditional', 'A must-visit for lovers of authentic Jordanian zarb, slow-cooked underground.', 'Jordan', 'Amman', 'https://goo.gl/maps/example1', 'contact@zarbhouse.com', '0791234567', '0797676767', 'https://zarbhouse.com', NULL, NULL, 'https://x.com/home', 'assets/images/places/restaurants/RM(1).jpg', '2025-03-15 14:37:28'),
(2, 2, 1, 'Habibah Sweets', '$', 'Desserts, Sweets, Kunafa', 'Famous for its mouthwatering kunafa, a true taste of Amman.', 'Jordan', 'Amman', 'https://goo.gl/maps/example2', 'info@habibahsweets.com', '0792345678', NULL, NULL, 'https://facebook.com/habibah', NULL, 'https://x.com/home', 'assets/images/places/restaurants/RM(2).jpg', '2025-03-15 14:37:28'),
(3, 3, 1, 'Shawarma Reem', '$', 'Shawarma, Fast Food, Street Food', 'One of the best shawarma spots in Amman, known for its rich flavors.', 'Jordan', 'Amman', 'https://goo.gl/maps/example3', NULL, '0793456789', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/restaurants/RM(3).jpg', '2025-03-15 14:37:28'),
(4, 4, 1, 'Fakhr El-Din', '$$$', 'Lebanese, Fine Dining', 'A high-end Lebanese restaurant offering exquisite dishes and great ambiance.', 'Jordan', 'Amman', 'https://goo.gl/maps/example4', 'reservations@fakhreldin.com', '0794567890', NULL, 'https://fakhreldin.com', 'https://facebook.com/fakhreldin', 'https://instagram.com/fakhreldin', NULL, 'assets/images/places/restaurants/RM(4).jpg', '2025-03-15 14:37:28'),
(5, 5, 1, 'Rakwet Arab', '$$', 'Middle Eastern, Café', 'A cozy spot offering shisha, delicious food, and a vibrant atmosphere.', 'Jordan', 'Amman', 'https://goo.gl/maps/example5', NULL, '0795678901', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/restaurants/RM(5).jpg', '2025-03-15 14:37:28'),
(6, 6, 1, 'Tawaheen Al-Hawa', '$$', 'Jordanian, Traditional', 'A classic restaurant serving traditional Jordanian dishes with a warm ambiance.', 'Jordan', 'Amman', 'https://goo.gl/maps/example6', 'info@tawaheen.com', '0796789012', NULL, 'https://tawaheen.com', NULL, NULL, NULL, 'assets/images/places/restaurants/RM(6).jpg', '2025-03-15 14:37:28'),
(7, 7, 1, 'Cantaloupe Gastro Pub', '$$$', 'International, Fine Dining', 'A stylish rooftop restaurant offering great views and gourmet cuisine.', 'Jordan', 'Amman', 'https://goo.gl/maps/example7', 'info@cantaloupe.com', '0797890123', NULL, 'https://cantaloupe.com', 'https://facebook.com/cantaloupejo', 'https://instagram.com/cantaloupejo', NULL, 'assets/images/places/restaurants/RM(7).jpg', '2025-03-15 14:37:28'),
(8, 8, 1, 'Al-Quds Falafel', '$', 'Falafel, Street Food', 'A legendary falafel spot in Amman, serving the best in the city.', 'Jordan', 'Amman', 'https://goo.gl/maps/example8', NULL, '0798901234', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/restaurants/RM(8).jpg', '2025-03-15 14:37:28'),
(9, 9, 2, 'Taj Mall', '$$$', 'Shopping Mall, Fashion, Entertainment', 'A luxurious shopping mall with international brands and entertainment facilities.', 'Jordan', 'Amman', 'https://goo.gl/maps/example9', 'info@tajmall.com', '0799012345', '0797676767', 'https://tajmall.com', 'https://facebook.com/tajmalljo', NULL, NULL, 'assets/images/places/shopping/sh(1).jpg', '2025-03-15 14:37:28'),
(10, 10, 2, 'City Mall', '$$', 'Shopping Mall, Retail, Dining', 'A family-friendly mall with a variety of shops, restaurants, and a cinema.', 'Jordan', 'Amman', 'https://goo.gl/maps/example10', NULL, '0790123456', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/shopping/sh(2).jpg', '2025-03-15 14:37:28'),
(11, 11, 2, 'Souq Jara', '$', 'Handicrafts, Antiques, Local Market', 'A seasonal outdoor market featuring handmade crafts and traditional products.', 'Jordan', 'Amman', 'https://goo.gl/maps/example11', NULL, '0791234567', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/shopping/sh(3).jpg', '2025-03-15 14:37:28'),
(12, 12, 2, 'Al Balad Shops', '$$', 'Traditional, Souvenirs, Local', 'Explore the heart of Amman with its authentic local shops and markets.', 'Jordan', 'Amman', 'https://goo.gl/maps/example12', 'info@albaladshops.com', '0792345678', NULL, NULL, 'https://facebook.com/albaladshops', NULL, NULL, 'assets/images/places/shopping/sh(4).jpg', '2025-03-15 14:37:28'),
(13, 13, 2, 'Abdali Mall', '$$$', 'Luxury Shopping, Fashion', 'A modern mall offering high-end fashion brands and fine dining.', 'Jordan', 'Amman', 'https://goo.gl/maps/example13', 'info@abdalimall.com', '0793456789', NULL, 'https://abdalimall.com', NULL, 'https://instagram.com/abdalimall', 'https://x.com/home', 'assets/images/places/shopping/sh(5).jpg', '2025-03-15 14:37:28'),
(14, 14, 2, 'Galleria Mall', '$$', 'Fashion, Entertainment', 'A trendy shopping mall with a variety of international and local brands.', 'Jordan', 'Amman', 'https://goo.gl/maps/example14', NULL, '0794567890', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/shopping/sh(6).jpg', '2025-03-15 14:37:28'),
(15, 15, 2, 'Rainbow Street Shops', '$', 'Handmade, Local Artisans', 'Boutiques and craft shops offering unique handmade gifts.', 'Jordan', 'Amman', 'https://goo.gl/maps/example15', NULL, '0795678901', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/shopping/sh(7).jpg', '2025-03-15 14:37:28'),
(16, 16, 2, 'Mecca Mall', '$$', 'Family Shopping, Dining', 'A well-known shopping destination with a variety of stores and restaurants.', 'Jordan', 'Amman', 'https://goo.gl/maps/example16', 'info@meccamall.com', '0796789012', '0797676767', 'https://meccamall.com', 'https://facebook.com/meccamall', 'https://instagram.com/meccamall', NULL, 'assets/images/places/shopping/sh(8).jpg', '2025-03-15 14:37:28'),
(17, 17, 3, 'Climbat Amman', '$$', 'Rock Climbing, Adventure', 'An indoor rock climbing center suitable for all skill levels.', 'Jordan', 'Amman', 'https://goo.gl/maps/example17', 'info@climbat.com', '0797890123', NULL, 'https://climbat.com', NULL, 'https://instagram.com/climbat', NULL, 'assets/images/places/active-life/a(1).jpg', '2025-03-15 14:37:28'),
(18, 18, 3, 'The Boulevard', '$$$', 'Walking, Shopping, Entertainment', 'A lively urban destination with cafes, shops, and events.', 'Jordan', 'Amman', 'https://goo.gl/maps/example18', 'info@theboulevard.com', '0798901234', '0797676767', 'https://theboulevard.com', 'https://facebook.com/theboulevard', NULL, NULL, 'assets/images/places/active-life/a(2).jpg', '2025-03-15 14:37:28'),
(19, 19, 3, 'Cycling Jordan', '$$', 'Biking, Tours, Outdoors', 'Offering scenic cycling tours across Jordan’s landscapes.', 'Jordan', 'Amman', 'https://goo.gl/maps/example19', NULL, '0799012345', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/active-life/a(3).jpg', '2025-03-15 14:37:28'),
(20, 20, 3, 'Amman Waves', '$$', 'Water Park, Family Fun', 'A fun-filled water park featuring pools, slides, and relaxation spots.', 'Jordan', 'Amman', 'https://goo.gl/maps/example20', 'info@ammanwaves.com', '0790123456', NULL, 'https://ammanwaves.com', 'https://facebook.com/ammanwaves', NULL, 'https://x.com/home', 'assets/images/places/active-life/a(4).jpg', '2025-03-15 14:37:28'),
(21, 21, 3, 'Jungle Bungee', '$$$', 'Extreme Sports, Adventure', 'The first bungee jumping experience in Jordan for thrill-seekers.', 'Jordan', 'Amman', 'https://goo.gl/maps/example21', NULL, '0791234567', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/active-life/a(5).jpg', '2025-03-15 14:37:28'),
(22, 22, 3, 'Paintball Amman', '$$', 'Team Games, Sports', 'A thrilling paintball arena perfect for team challenges.', 'Jordan', 'Amman', 'https://goo.gl/maps/example22', NULL, '0792345678', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/active-life/a(6).jpg', '2025-03-15 14:37:28'),
(23, 1, 4, 'Fix It Jordan', '$$', 'Plumbing, Electrical, Repairs', 'A reliable home maintenance service offering plumbing, electrical, and general repairs.', 'Jordan', 'Amman', 'https://goo.gl/maps/example23', 'support@fixitjo.com', '0791234567', '0797676767', 'https://fixitjo.com', 'https://facebook.com/fixitjo', NULL, NULL, 'assets/images/places/home s/h(1).jpg', '2025-03-15 14:38:03'),
(24, 2, 4, 'Quick Clean', '$$', 'Cleaning, Housekeeping', 'Professional cleaning services for homes and offices with top-quality standards.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example24', 'info@quickclean.com', '0792345678', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/home s/h(2).jpg', '2025-03-15 14:38:03'),
(25, 3, 4, 'Green Roof', '$$$', 'Landscaping, Gardening', 'Specializing in eco-friendly garden and landscape design.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example25', 'contact@greenroof.com', '0793456789', NULL, 'https://greenroof.com', 'https://facebook.com/greenroofjo', 'https://instagram.com/greenroofjo', NULL, 'assets/images/places/home s/h(3).jpg', '2025-03-15 14:38:03'),
(26, 4, 4, 'Smart Home Jordan', '$$$', 'Automation, Security', 'Upgrade your home with smart automation and security solutions.', 'Jordan', 'Amman', 'https://goo.gl/maps/example26', 'info@smarthomejo.com', '0794567890', NULL, 'https://smarthomejo.com', NULL, NULL, NULL, 'assets/images/places/home s/h(4).jpg', '2025-03-15 14:38:03'),
(27, 5, 4, 'HandyMan Pro', '$$', 'General Repairs, Home Fixes', 'Expert handyman services for all household repairs and improvements.', 'Jordan', 'Madaba', 'https://goo.gl/maps/example27', NULL, '0795678901', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/home s/h(5).jpg', '2025-03-15 14:38:03'),
(28, 6, 4, 'Elite Movers', '$$$', 'Moving, Packing, Storage', 'Professional moving services for local and international relocations.', 'Jordan', 'Amman', 'https://goo.gl/maps/example28', 'info@elitemovers.com', '0796789012', NULL, 'https://elitemovers.com', 'https://facebook.com/elitemoversjo', NULL, NULL, 'assets/images/places/home s/h(7).jpg', '2025-03-15 14:38:03'),
(29, 7, 4, 'Aqua Fix', '$', 'Plumbing, Water Leaks', 'Affordable plumbing solutions for residential and commercial properties.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example29', NULL, '0797890123', NULL, NULL, NULL, NULL, 'https://x.com/home', 'assets/images/places/home s/h(8).jpg', '2025-03-15 14:38:03'),
(30, 8, 4, 'Pest Control Jordan', '$$', 'Pest Removal, Disinfection', 'Effective pest control solutions for homes and businesses.', 'Jordan', 'Amman', 'https://goo.gl/maps/example30', 'support@pestcontroljo.com', '0798901234', '0797676767', 'https://pestcontroljo.com', NULL, 'https://instagram.com/pestcontroljo', NULL, 'assets/images/places/home s/h(9).jpg', '2025-03-15 14:38:03'),
(31, 9, 4, 'Aircon Experts', '$$', 'AC Installation, Maintenance', 'Specialists in air conditioning installation and maintenance.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example31', 'info@airconexperts.com', '0799012345', NULL, NULL, 'https://facebook.com/airconexperts', NULL, NULL, 'assets/images/places/home s/h(10).jpg', '2025-03-15 14:38:03'),
(32, 10, 4, 'Home Painters', '$$', 'Painting, Interior Design', 'Quality painting services to refresh your home’s interior and exterior.', 'Jordan', 'Amman', 'https://goo.gl/maps/example32', NULL, '0790123456', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/home s/h(11).jpg', '2025-03-15 14:38:03'),
(33, 11, 4, 'Glass & Mirror Works', '$$$', 'Glass Installation, Repairs', 'Custom glass and mirror solutions for homes and offices.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example33', 'info@glassmirrorjo.com', '0791234567', NULL, 'https://glassmirrorjo.com', 'https://facebook.com/glassmirrorjo', NULL, NULL, 'assets/images/places/home s/h(12).jpg', '2025-03-15 14:38:03'),
(34, 12, 4, 'SolarTech Jordan', '$$$', 'Solar Panels, Renewable Energy', 'Providing solar energy solutions to make homes more sustainable.', 'Jordan', 'Amman', 'https://goo.gl/maps/example34', 'support@solartechjo.com', '0792345678', NULL, 'https://solartechjo.com', NULL, 'https://instagram.com/solartechjo', NULL, 'assets/images/places/home s/h(13).jpg', '2025-03-15 14:38:03'),
(35, 1, 5, 'Brew & Beans', '$$', 'Specialty Coffee, Pastries, Cozy', 'A cozy café offering specialty coffee, fresh pastries, and a relaxing ambiance.', 'Jordan', 'Amman', 'https://goo.gl/maps/example1', 'contact@brewandbeans.com', '0791111111', NULL, 'https://brewandbeans.com', 'https://facebook.com/brewandbeans', 'https://instagram.com/brewandbeans', NULL, 'assets/images/places/Coffee/c(1).jpg', '2025-03-15 14:39:19'),
(36, 2, 5, 'The Roastery', '$$', 'Fresh Coffee, Organic, Chill Spot', 'Known for its organic coffee beans and relaxed atmosphere, a perfect place to unwind.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example2', NULL, '0792222222', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/Coffee/c(2).jpg', '2025-03-15 14:39:19'),
(37, 3, 5, 'Café Aroma', '$$', 'Espresso, Desserts, Outdoor Seating', 'Serving rich espresso drinks and delicious desserts with outdoor seating.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example3', 'info@cafearoma.com', '0793333333', NULL, 'https://cafearoma.com', NULL, 'https://instagram.com/cafearoma', NULL, 'assets/images/places/Coffee/c(3).jpg', '2025-03-15 14:39:19'),
(38, 4, 5, 'Daily Dose Coffee', '$$', 'Takeaway, Breakfast, Quick Service', 'A fast-paced coffee shop ideal for grabbing a quick morning coffee and snack.', 'Jordan', 'Amman', 'https://goo.gl/maps/example4', 'hello@dailydose.com', '0794444444', NULL, NULL, 'https://facebook.com/dailydosecoffee', NULL, 'https://x.com/home', 'assets/images/places/Coffee/c(4).jpg', '2025-03-15 14:39:19'),
(39, 5, 5, 'Black & White Café', '$$$', 'Artistic, Specialty Blends, Events', 'A stylish café with handcrafted coffee blends and live music events.', 'Jordan', 'Madaba', 'https://goo.gl/maps/example5', 'info@blackwhitecafe.com', '0795555555', NULL, 'https://blackwhitecafe.com', NULL, 'https://instagram.com/blackwhitecafe', NULL, 'assets/images/places/Coffee/c(5).jpg', '2025-03-15 14:39:19'),
(40, 6, 5, 'Horizon Coffee House', '$$', 'Vegan Options, Books, Relaxing', 'A peaceful café with vegan-friendly options and a cozy reading corner.', 'Jordan', 'Amman', 'https://goo.gl/maps/example6', NULL, '0796666666', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/Coffee/c(6).jpg', '2025-03-15 14:39:19'),
(41, 7, 5, 'Espresso Express', '$', 'Quick Coffee, Affordable, Local Favorite', 'A budget-friendly coffee spot known for strong espresso and fast service.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example7', NULL, '0797777777', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/Coffee/c(7).jpg', '2025-03-15 14:39:19'),
(42, 8, 5, 'Golden Beans', '$$', 'Premium Coffee, Roastery, Calm Atmosphere', 'Offering premium coffee beans roasted in-house for a truly fresh experience.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example8', 'contact@goldenbeans.com', '0798888888', NULL, NULL, 'https://facebook.com/goldenbeans', NULL, NULL, 'assets/images/places/Coffee/c(8).jpg', '2025-03-15 14:39:19'),
(43, 9, 5, 'Retro Café', '$$', 'Vintage Vibes, Great Music, Chill', 'A vintage-style café with old-school music and a unique interior.', 'Jordan', 'Amman', 'https://goo.gl/maps/example9', 'retro@cafe.com', '0799999999', NULL, 'https://retrocafe.com', 'https://facebook.com/retrocafe', 'https://instagram.com/retrocafe', NULL, 'assets/images/places/Coffee/c(9).jpg', '2025-03-15 14:39:19'),
(44, 10, 5, 'Moonlight Coffee', '$$', 'Late Night, Study Spot, Espresso', 'A great place for night owls who need a caffeine boost while working or studying.', 'Jordan', 'Madaba', 'https://goo.gl/maps/example10', NULL, '0791010101', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/Coffee/c(10).jpg', '2025-03-15 14:39:19'),
(45, 11, 5, 'The Coffee Lab', '$$$', 'Experimental Drinks, Science-Themed', 'A science-inspired café offering unique coffee experiments and blends.', 'Jordan', 'Amman', 'https://goo.gl/maps/example11', 'info@coffeelab.com', '0791111212', NULL, 'https://coffeelab.com', 'https://facebook.com/coffeelabjo', NULL, NULL, 'assets/images/places/Coffee/c(11).jpg', '2025-03-15 14:39:19'),
(46, 12, 5, 'Caffeine Rush', '$', 'Cheap & Strong, Student Spot', 'An affordable café known for its extra-strong coffee and student-friendly environment.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example12', NULL, '0791212121', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/Coffee/c(12).jpg', '2025-03-15 14:39:19'),
(47, 13, 5, 'Sunset Café', '$$', 'Scenic Views, Smoothies, Lounge', 'Enjoy your coffee with a stunning sunset view and relaxing lounge music.', 'Jordan', 'Aqaba', 'https://goo.gl/maps/example13', 'hello@sunsetcafe.com', '0791313131', '0797676767', NULL, 'https://facebook.com/sunsetcafe', 'https://instagram.com/sunsetcafe', 'https://x.com/home', 'assets/images/places/Coffee/c(13).jpg', '2025-03-15 14:39:19'),
(48, 14, 5, 'Java Junction', '$$', 'Friendly Staff, Cozy, Community Hub', 'A friendly neighborhood café with a welcoming atmosphere and great coffee.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example14', 'support@javajunction.com', '0791414141', NULL, 'https://javajunction.com', 'https://facebook.com/javajunction', NULL, NULL, 'assets/images/places/Coffee/c(14).jpg', '2025-03-15 14:39:19'),
(49, 15, 5, 'Cuppa Joy', '$$', 'Artistic, Board Games, Dessert Menu', 'A fun café offering board games, artistic décor, and a delicious dessert selection.', 'Jordan', 'Amman', 'https://goo.gl/maps/example15', NULL, '0791515151', NULL, NULL, NULL, 'https://instagram.com/cuppajoy', NULL, 'assets/images/places/Coffee/c(15).jpg', '2025-03-15 14:39:19'),
(50, 1, 6, 'Pawfect Pet Store', '$$', 'Pet Food, Accessories, Grooming', 'A one-stop shop for all pet needs, offering high-quality pet food, accessories, and grooming services.', 'Jordan', 'Amman', 'https://goo.gl/maps/example16', 'info@pawfectpet.com', '0791616161', NULL, 'https://pawfectpet.com', 'https://facebook.com/pawfectpet', 'https://instagram.com/pawfectpet', NULL, 'assets/images/places/pets/pets(1).jpg', '2025-03-15 14:40:31'),
(51, 2, 6, 'Happy Tails Veterinary', '$$$', 'Veterinary, Emergency Care, Pet Surgery', 'A trusted veterinary clinic providing pet checkups, emergency care, and surgical procedures.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example17', 'support@happytails.com', '0791717171', NULL, 'https://happytailsvet.com', 'https://facebook.com/happytailsvet', NULL, NULL, 'assets/images/places/pets/pets(2).jpg', '2025-03-15 14:40:31'),
(52, 3, 6, 'Furry Friends Café', '$$', 'Pet-Friendly, Coffee, Play Area', 'A unique café where you can enjoy coffee while your pets play in a dedicated space.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example18', 'contact@furryfriendscafe.com', '0791818181', NULL, NULL, 'https://facebook.com/furryfriendscafe', 'https://instagram.com/furryfriendscafe', NULL, 'assets/images/places/pets/pets(3).jpg', '2025-03-15 14:40:31'),
(53, 4, 6, 'Whiskers & Wags', '$$', 'Pet Boutique, Custom Accessories', 'An upscale pet boutique offering stylish pet clothes, beds, and custom accessories.', 'Jordan', 'Amman', 'https://goo.gl/maps/example19', 'info@whiskerswags.com', '0791919191', NULL, NULL, NULL, 'https://instagram.com/whiskerswags', NULL, 'assets/images/places/pets/pets(4).jpg', '2025-03-15 14:40:31'),
(54, 5, 6, 'Royal Pet Spa', '$$$', 'Luxury Grooming, Spa Treatments', 'A premium grooming spa offering fur treatments, nail trimming, and aromatherapy for pets.', 'Jordan', 'Madaba', 'https://goo.gl/maps/example20', 'contact@royalpetspa.com', '0792020202', '0797676767', 'https://royalpetspa.com', 'https://facebook.com/royalpetspa', NULL, NULL, 'assets/images/places/pets/pets(5).jpg', '2025-03-15 14:40:31'),
(55, 6, 6, 'Bark & Bite', '$', 'Budget-Friendly Pet Store', 'A pet supply store with affordable prices on food, toys, and health products.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example21', NULL, '0792121212', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/pets/pets(6).jpg', '2025-03-15 14:40:31'),
(56, 7, 6, 'The Paw Palace', '$$', 'Pet Boarding, Daycare, Training', 'Offering pet boarding, daycare, and training services with professional staff.', 'Jordan', 'Aqaba', 'https://goo.gl/maps/example22', 'hello@pawpalace.com', '0792222222', NULL, NULL, 'https://facebook.com/thepawpalace', 'https://instagram.com/thepawpalace', 'https://x.com/home', 'assets/images/places/pets/pets(7).jpg', '2025-03-15 14:40:31'),
(57, 8, 6, 'VetCare Plus', '$$$', 'Pet Hospital, Vaccinations, Surgery', 'A full-service animal hospital providing vaccinations, treatments, and emergency care.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example23', 'info@vetcareplus.com', '0792323232', NULL, 'https://vetcareplus.com', 'https://facebook.com/vetcareplus', NULL, 'https://x.com/home', 'assets/images/places/pets/pets(8).jpg', '2025-03-15 14:40:31'),
(58, 15, 7, 'Green Haven', '$$', 'Indoor Plants, Outdoor Plants, Pots', 'A premium plant store offering a wide variety of indoor and outdoor plants, along with stylish pots.', 'Jordan', 'Amman', 'https://goo.gl/maps/example24', 'contact@greenhaven.com', '0792414141', NULL, 'https://greenhaven.com', 'https://facebook.com/greenhaven', 'https://instagram.com/greenhaven', NULL, 'assets/images/places/plants/plants(1).jpg', '2025-03-15 14:42:15'),
(59, 16, 7, 'Bloom & Grow', '$$', 'Flowering Plants, Succulents, Gardening Tools', 'A boutique plant shop specializing in vibrant flowering plants and succulent arrangements.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example25', 'info@bloomgrow.com', '0792525252', NULL, 'https://bloomgrow.com', 'https://facebook.com/bloomgrow', NULL, NULL, 'assets/images/places/plants/plants(2).jpg', '2025-03-15 14:42:15'),
(60, 17, 7, 'Urban Jungle', '$$$', 'Exotic Plants, Rare Species, Bonsai', 'A paradise for plant lovers, featuring exotic and rare plant species, including bonsai trees.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example26', 'support@urbanjungle.com', '0792626262', NULL, 'https://urbanjungle.com', 'https://facebook.com/urbanjungle', 'https://instagram.com/urbanjungle', NULL, 'assets/images/places/plants/plants(3).jpg', '2025-03-15 14:42:15'),
(61, 18, 7, 'Leaf & Root', '$$', 'Houseplants, Plant Care, Workshops', 'A cozy shop that offers houseplants, plant care essentials, and gardening workshops.', 'Jordan', 'Madaba', 'https://goo.gl/maps/example27', 'hello@leafroot.com', '0792727272', NULL, NULL, NULL, 'https://instagram.com/leafroot', NULL, 'assets/images/places/plants/plants(4).jpg', '2025-03-15 14:42:15'),
(62, 19, 7, 'Nature’s Touch', '$', 'Budget Plants, Seeds, Organic Fertilizers', 'An affordable plant shop offering budget-friendly options, organic fertilizers, and seeds.', 'Jordan', 'Aqaba', 'https://goo.gl/maps/example28', NULL, '0792828282', NULL, NULL, NULL, NULL, NULL, 'assets/images/places/plants/plants(5).jpg', '2025-03-15 14:42:15'),
(63, 22, 7, 'The Green Corner', '$$', 'Terrariums, Indoor Plants, Accessories', 'A specialty store featuring beautifully crafted terrariums and indoor plant arrangements.', 'Jordan', 'Amman', 'https://goo.gl/maps/example29', 'info@greencorner.com', '0792929292', NULL, NULL, 'https://facebook.com/thegreencorner', NULL, NULL, 'assets/images/places/plants/plants(6).jpg', '2025-03-15 14:42:15'),
(64, 30, 7, 'Flora Bliss', '$$', 'Air-Purifying Plants, Decorative Planters', 'A shop focused on air-purifying plants and aesthetic planters to beautify your home.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example30', NULL, '0793030303', NULL, 'https://florabliss.com', NULL, NULL, NULL, 'assets/images/places/plants/plants(7).jpg', '2025-03-15 14:42:15'),
(65, 20, 7, 'Botanic Wonders', '$$$', 'Rare Plants, Custom Landscaping, Greenhouses', 'A high-end plant shop offering rare plant species, custom landscaping services, and greenhouses.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example31', 'info@botanicwonders.com', '0793131313', '0797676767', 'https://botanicwonders.com', 'https://facebook.com/botanicwonders', 'https://instagram.com/botanicwonders', NULL, 'assets/images/places/plants/plants(8).jpg', '2025-03-15 14:42:15'),
(66, 8, 8, 'Art House Gallery', '$$$', 'Contemporary Art, Exhibitions, Paintings', 'A high-end art gallery showcasing contemporary paintings, sculptures, and exhibitions by local artists.', 'Jordan', 'Amman', 'https://goo.gl/maps/example32', 'contact@arthousegallery.com', '0793232323', NULL, 'https://arthousegallery.com', 'https://facebook.com/arthousegallery', 'https://instagram.com/arthousegallery', NULL, 'assets/images/places/art/art(1).jpg', '2025-03-15 14:43:36'),
(67, 10, 8, 'The Painted Canvas', '$$', 'Art Classes, Paintings, Pottery', 'A creative space offering art classes and workshops, along with a collection of pottery and paintings by local artists.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example33', 'info@paintedcanvas.com', '0793333333', NULL, 'https://paintedcanvas.com', NULL, 'https://instagram.com/paintedcanvas', NULL, 'assets/images/places/art/art(2).jpg', '2025-03-15 14:43:36'),
(68, 16, 8, 'Gallery 9', '$$$', 'Modern Art, Sculptures, Art Exhibitions', 'A prestigious gallery known for its exhibitions of modern art and sculptures by both local and international artists.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example34', 'support@gallery9.com', '0793434343', NULL, 'https://gallery9.com', 'https://facebook.com/gallery9', 'https://instagram.com/gallery9', NULL, 'assets/images/places/art/art(3).jpg', '2025-03-15 14:43:36'),
(69, 18, 8, 'The Art Lab', '$$', 'Interactive Art, Workshops, Exhibitions', 'A unique space for interactive art exhibitions and workshops where visitors can create their own art under the guidance of professional artists.', 'Jordan', 'Madaba', 'https://goo.gl/maps/example35', 'hello@artlab.com', '0793535353', NULL, 'https://artlab.com', NULL, NULL, 'https://x.com/home', 'assets/images/places/art/art(4).jpg', '2025-03-15 14:43:36'),
(70, 32, 8, 'Sketch & Frame', '$$', 'Art Frames, Sketches, Art Supplies', 'A store offering custom framing services, art supplies, and beautiful sketches for sale from talented local artists.', 'Jordan', 'Aqaba', 'https://goo.gl/maps/example36', 'contact@sketchandframe.com', '0793636363', NULL, 'https://sketchandframe.com', NULL, NULL, NULL, 'assets/images/places/art/art(5).jpg', '2025-03-15 14:43:36'),
(71, 26, 8, 'Art Space', '$$$', 'Art Exhibitions, Paintings, Art Installations', 'An innovative space for large-scale art installations and exhibitions, focusing on both experimental and traditional art forms.', 'Jordan', 'Amman', 'https://goo.gl/maps/example37', 'info@artspace.com', '0793737373', NULL, 'https://artspace.com', 'https://facebook.com/artspace', 'https://instagram.com/artspace', NULL, 'assets/images/places/art/art(6).jpg', '2025-03-15 14:43:36'),
(72, 12, 8, 'Creative Hive', '$$', 'Art Classes, Photography, Painting', 'A creative hub offering classes in various art forms such as photography, painting, and digital art.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example38', 'contact@creativehive.com', '0793838383', NULL, 'https://creativehive.com', NULL, NULL, NULL, 'assets/images/places/art/art(7).jpg', '2025-03-15 14:43:36'),
(73, 25, 8, 'The Canvas Room', '$$', 'Painting, Art Workshops, Art Supplies', 'A cozy studio where visitors can take painting lessons and explore a variety of art supplies for their creative needs.', 'Jordan', 'Zarqa', 'https://goo.gl/maps/example39', 'hello@canvasroom.com', '0793939393', '0797676767', 'https://canvasroom.com', 'https://facebook.com/canvasroom', 'https://instagram.com/canvasroom', NULL, 'assets/images/places/art/art(8).jpg', '2025-03-15 14:43:36'),
(74, 2, 9, 'Jordan Palace Hotel', '$$$', 'Luxury, Spa, Swimming Pool, City Center', 'A luxury hotel located in the heart of Amman, featuring a full-service spa, a rooftop pool, and stunning city views.', 'Jordan', 'Amman', 'https://goo.gl/maps/example40', 'info@jordanpalacehotel.com', '0793030303', NULL, 'https://jordanpalacehotel.com', 'https://facebook.com/jordanpalacehotel', 'https://instagram.com/jordanpalacehotel', NULL, 'assets/images/places/Hotel/hotel(1).jpg', '2025-03-15 14:44:43'),
(75, 4, 9, 'Red Sea Resort Hotel', '$$', 'Beachfront, Family-friendly, Pool', 'A family-friendly resort located on the shores of Aqaba, offering beachfront views, a large pool, and activities for all ages.', 'Jordan', 'Aqaba', 'https://goo.gl/maps/example41', 'reservations@redsearesorthotel.com', '0793131313', NULL, 'https://redsearesorthotel.com', NULL, NULL, NULL, 'assets/images/places/Hotel/hotel(2).jpg', '2025-03-15 14:44:43'),
(76, 6, 9, 'The Dead Sea Marriott Resort', '$$$', 'Dead Sea, Luxury, Spa, Wellness', 'An exclusive luxury resort by the Dead Sea, offering therapeutic mud baths, spa treatments, and relaxation with breathtaking views of the Dead Sea.', 'Jordan', 'Sweimeh', 'https://goo.gl/maps/example42', 'info@deadseamarriott.com', '0793232323', NULL, 'https://deadseamarriott.com', 'https://facebook.com/deadseamarriott', 'https://instagram.com/deadseamarriott', NULL, 'assets/images/places/Hotel/hotel(3).jpg', '2025-03-15 14:44:43'),
(77, 8, 9, 'Petra Palace Hotel', '$$$', 'Historic, Petra, Luxury, Pool', 'Located near the ancient city of Petra, this hotel offers luxury accommodations, panoramic views, and easy access to the ruins of Petra.', 'Jordan', 'Petra', 'https://goo.gl/maps/example43', 'contact@petrapalacehotel.com', '0793333333', NULL, 'https://petrapalacehotel.com', 'https://facebook.com/petrapalacehotel', 'https://instagram.com/petrapalacehotel', NULL, 'assets/images/places/Hotel/hotel(4).jpg', '2025-03-15 14:44:43'),
(78, 10, 9, 'Amman Marriott Hotel', '$$$', 'Business, Luxury, Conference Rooms', 'A modern business hotel located in the center of Amman, featuring luxurious rooms, conference facilities, and exquisite dining options.', 'Jordan', 'Amman', 'https://goo.gl/maps/example44', 'info@ammanmarriotthotel.com', '0793434343', NULL, 'https://ammanmarriotthotel.com', 'https://facebook.com/ammanmarriotthotel', 'https://instagram.com/ammanmarriotthotel', NULL, 'assets/images/places/Hotel/hotel(5).jpg', '2025-03-15 14:44:43'),
(79, 12, 9, 'Movenpick Resort & Spa Dead Sea', '$$$', 'Luxury, Wellness, Spa, Beachfront', 'A luxury resort offering relaxation and wellness with direct access to the Dead Sea, including an exclusive spa and stunning beachfront views.', 'Jordan', 'Sweimeh', 'https://goo.gl/maps/example45', 'reservations@movenpick.com', '0793535353', NULL, 'https://movenpick.com/dead-sea', 'https://facebook.com/movenpick', 'https://instagram.com/movenpick', 'https://x.com/home', 'assets/images/places/Hotel/hotel(6).jpg', '2025-03-15 14:44:43'),
(80, 14, 9, 'Kempinski Hotel Aqaba', '$$$', 'Beachfront, Spa, Luxury, Pools', 'A five-star beachfront resort in Aqaba with stunning views of the Red Sea, offering luxury amenities, a full-service spa, and multiple dining options.', 'Jordan', 'Aqaba', 'https://goo.gl/maps/example46', 'info@kempinski.com', '0793636363', NULL, 'https://kempinski.com/aqaba', 'https://facebook.com/kempinski', 'https://instagram.com/kempinski', NULL, 'assets/images/places/Hotel/hotel(7).jpg', '2025-03-15 14:44:43'),
(81, 16, 9, 'The Ritz-Carlton, Amman', '$$$', 'Luxury, Business, Pool, Spa', 'This luxury hotel in Amman combines elegant accommodations with a world-class spa, business center, and rooftop pool overlooking the city.', 'Jordan', 'Amman', 'https://goo.gl/maps/example47', 'contact@ritzcarlton.com', '0793737373', NULL, 'https://ritzcarlton.com/amman', 'https://facebook.com/ritzcarlton', 'https://instagram.com/ritzcarlton', NULL, 'assets/images/places/Hotel/hotel(8).jpg', '2025-03-15 14:44:43'),
(82, 18, 9, 'Crowne Plaza Resort Dead Sea', '$$$', 'Dead Sea, Wellness, Resort', 'An elegant resort offering luxury accommodations by the Dead Sea, along with wellness facilities, spas, and recreational activities.', 'Jordan', 'Sweimeh', 'https://goo.gl/maps/example48', 'reservations@crowneplazadeadsea.com', '0793838383', NULL, 'https://crowneplazadeadsea.com', 'https://facebook.com/crowneplazadeadsea', 'https://instagram.com/crowneplazadeadsea', NULL, 'assets/images/places/Hotel/hotel(9).jpg', '2025-03-15 14:44:43'),
(83, 20, 9, 'Bristol Hotel Amman', '$$', 'Business, Modern, Conference', 'A modern hotel located in the heart of Amman, ideal for business travelers with conference rooms, free Wi-Fi, and a central location.', 'Jordan', 'Amman', 'https://goo.gl/maps/example49', 'contact@bristolhotel.com', '0793939393', NULL, 'https://bristolhotel.com', 'https://facebook.com/bristolhotel', 'https://instagram.com/bristolhotel', NULL, 'assets/images/places/Hotel/hotel(10).jpg', '2025-03-15 14:44:43'),
(84, 22, 9, 'Le Meridien Amman', '$$$', 'Luxury, Business, Spa, Conference', 'Located in the heart of Amman, Le Meridien offers luxury accommodations, a full-service spa, and modern conference facilities.', 'Jordan', 'Amman', 'https://goo.gl/maps/example50', 'info@lemeridien.com', '0794040404', NULL, 'https://lemeridien.com/amman', 'https://facebook.com/lemeridienamman', 'https://instagram.com/lemeridienamman', NULL, 'assets/images/places/Hotel/hotel(11).jpg', '2025-03-15 14:44:43'),
(85, 24, 9, 'Dead Sea Spa Hotel', '$$', 'Dead Sea, Affordable, Spa', 'A more affordable option for those looking to experience the Dead Sea with a range of amenities including a spa, pools, and wellness treatments.', 'Jordan', 'Sweimeh', 'https://goo.gl/maps/example51', 'info@deadseaspahotel.com', '0794141414', NULL, 'https://deadseaspahotel.com', NULL, NULL, NULL, 'assets/images/places/Hotel/hotel(12).jpg', '2025-03-15 14:44:43'),
(86, 26, 9, 'Holiday Inn Resort Dead Sea', '$$$', 'Family-friendly, Resort, Pools, Beachfront', 'A family-friendly resort offering a wide range of activities, including a beachfront location, outdoor pools, and kids’ entertainment.', 'Jordan', 'Sweimeh', 'https://goo.gl/maps/example52', 'contact@holidayinnresortdeadsea.com', '0794242424', NULL, 'https://holidayinnresortdeadsea.com', NULL, NULL, NULL, 'assets/images/places/Hotel/hotel(13).jpg', '2025-03-15 14:44:43'),
(87, 28, 9, 'Grand Hyatt Amman', '$$$', 'Luxury, Business, Pool, Dining', 'An upscale hotel offering luxury services with a large pool, several fine-dining options, and a full-service business center.', 'Jordan', 'Amman', 'https://goo.gl/maps/example53', 'contact@grandhyatt.com', '0794343434', '0797676767', 'https://grandhyatt.com/amman', 'https://facebook.com/grandhyattamman', 'https://instagram.com/grandhyattamman', NULL, 'assets/images/places/Hotel/hotel(14).jpg', '2025-03-15 14:44:43'),
(88, 30, 9, 'Swiss-Belhotel Aqaba', '$$', 'Beachfront, Affordable, Modern', 'A modern hotel in Aqaba offering beautiful views of the Red Sea, affordable rates, and excellent customer service.', 'Jordan', 'Aqaba', 'https://goo.gl/maps/example54', 'reservations@swissbelhotel.com', '0794444444', '0797676767', 'https://swissbelhotel.com/aqaba', 'https://facebook.com/swissbelhotel', 'https://instagram.com/swissbelhotel', NULL, 'assets/images/places/Hotel/hotel(15).jpg', '2025-03-15 14:44:43'),
(89, 2, 10, 'Amman Academy', '$$$', 'Private, International, High School', 'Amman Academy offers a high-quality international education with a focus on preparing students for higher education abroad.', 'Jordan', 'Amman', 'https://goo.gl/maps/example55', 'info@ammanacademy.com', '0793030303', NULL, 'https://ammanacademy.com', 'https://facebook.com/ammanacademy', 'https://instagram.com/ammanacademy', 'https://x.com/home', 'assets/images/places/edu/edu(1).jpg', '2025-03-15 14:45:27'),
(90, 4, 10, 'Petra College', '$$', 'College, Higher Education, Arts', 'Petra College offers a range of undergraduate and graduate programs in arts and humanities, located near the ancient city of Petra.', 'Jordan', 'Petra', 'https://goo.gl/maps/example56', 'contact@petracollege.com', '0793131313', NULL, 'https://petracollege.com', NULL, NULL, NULL, 'assets/images/places/edu/edu(2).jpg', '2025-03-15 14:45:27'),
(91, 6, 10, 'Jordan University of Science and Technology', '$$$', 'University, Research, Science', 'One of the leading universities in Jordan, focusing on science, engineering, and technology, offering high-level research facilities.', 'Jordan', 'Irbid', 'https://goo.gl/maps/example57', 'info@just.edu.jo', '0793232323', NULL, 'https://just.edu.jo', 'https://facebook.com/jordanuniversityofscienceandtechnology', 'https://instagram.com/jordanuniversityofscienceandtechnology', NULL, 'assets/images/places/edu/edu(3).jpg', '2025-03-15 14:45:27'),
(92, 8, 10, 'The University of Jordan', '$$$', 'University, Research, Medicine', 'A premier university in Amman, known for its research in medicine, science, and engineering, with international collaborations.', 'Jordan', 'Amman', 'https://goo.gl/maps/example58', 'admissions@ju.edu.jo', '0793333333', NULL, 'https://ju.edu.jo', 'https://facebook.com/universityofjordan', 'https://instagram.com/universityofjordan', NULL, 'assets/images/places/edu/edu(4).jpg', '2025-03-15 14:45:27'),
(93, 10, 10, 'Al-Quds College', '$$', 'College, Technical, Vocational', 'Al-Quds College offers vocational and technical training programs, preparing students for the workforce in various fields.', 'Jordan', 'Amman', 'https://goo.gl/maps/example59', 'info@quds.edu.jo', '0793434343', NULL, 'https://quds.edu.jo', NULL, NULL, NULL, 'assets/images/places/edu/edu(5).jpg', '2025-03-15 14:45:27'),
(94, 12, 10, 'Jordan International School', '$$$', 'Private, International, K-12', 'An international school providing a comprehensive K-12 curriculum, preparing students for higher education globally.', 'Jordan', 'Amman', 'https://goo.gl/maps/example60', 'info@jordaninternationalschool.com', '0793535353', NULL, 'https://jordaninternationalschool.com', 'https://facebook.com/jordaninternationalschool', 'https://instagram.com/jordaninternationalschool', NULL, 'assets/images/places/edu/edu(6).jpg', '2025-03-15 14:45:27'),
(95, 14, 10, 'American University of Madaba', '$$$', 'University, American, Liberal Arts', 'The American University of Madaba offers a liberal arts education with an emphasis on American-style higher education and global perspectives.', 'Jordan', 'Madaba', 'https://goo.gl/maps/example61', 'admissions@aum.edu.jo', '0793636363', NULL, 'https://aum.edu.jo', 'https://facebook.com/americanuniversityofmadaba', 'https://instagram.com/americanuniversityofmadaba', NULL, 'assets/images/places/edu/edu(7).jpg', '2025-03-15 14:45:27'),
(96, 16, 10, 'University of Petra', '$$$', 'University, Private, Arts', 'A private university in Amman offering a wide range of programs with a focus on arts, engineering, and business education.', 'Jordan', 'Amman', 'https://goo.gl/maps/example62', 'admissions@uop.edu.jo', '0793737373', '0797676767', 'https://uop.edu.jo', 'https://facebook.com/universityofpetra', 'https://instagram.com/universityofpetra', 'https://x.com/home', 'assets/images/places/edu/edu(8).jpg', '2025-03-15 14:45:27'),
(97, 18, 10, 'Al-Balqa Applied University', '$$', 'University, Applied Sciences, Engineering', 'Al-Balqa University offers practical and applied science degrees, particularly in engineering and technical fields, with a focus on hands-on learning.', 'Jordan', 'Salt', 'https://goo.gl/maps/example63', 'info@bau.edu.jo', '0793838383', NULL, 'https://bau.edu.jo', NULL, NULL, NULL, 'assets/images/places/edu/edu(9).jpg', '2025-03-15 14:45:27'),
(98, 20, 10, 'King Hussein School', '$$', 'Private, High School, Science', 'A private school focusing on science and technology education for high school students, aiming to foster innovation and academic excellence.', 'Jordan', 'Amman', 'https://goo.gl/maps/example64', 'contact@khschool.com', '0793939393', NULL, 'https://khschool.com', NULL, NULL, NULL, 'assets/images/places/edu/edu(10).jpg', '2025-03-15 14:45:27'),
(99, 22, 10, 'Amman University College', '$$', 'College, Business, Technology', 'Amman University College offers various business and technology programs, providing quality education that prepares students for the modern workforce.', 'Jordan', 'Amman', 'https://goo.gl/maps/example65', 'info@auc.edu.jo', '0794040404', NULL, 'https://auc.edu.jo', NULL, NULL, NULL, 'assets/images/places/edu/edu(11).jpg', '2025-03-15 14:45:27'),
(100, 24, 10, 'Princess Sumaya University for Technology', '$$$', 'University, Technology, Research', 'PSUT is a leading Jordanian university focused on technology and innovation, offering cutting-edge programs in computer science and engineering.', 'Jordan', 'Amman', 'https://goo.gl/maps/example66', 'admissions@psut.edu.jo', '0794141414', NULL, 'https://psut.edu.jo', 'https://facebook.com/psut.edu.jo', 'https://instagram.com/psut.edu.jo', NULL, 'assets/images/places/edu/edu(12).jpg', '2025-03-15 14:45:27'),
(101, 26, 10, 'Al-Ahliyya Amman University', '$$', 'University, Business, Engineering', 'A private university known for its strong business and engineering programs, preparing students for leadership roles in various industries.', 'Jordan', 'Amman', 'https://goo.gl/maps/example67', 'info@aau.edu.jo', '0794242424', '0797676767', 'https://aau.edu.jo', NULL, NULL, 'https://x.com/home', 'assets/images/places/edu/edu(13).jpg', '2025-03-15 14:45:27'),
(102, 28, 10, 'Applied Science University', '$$', 'University, Business, Law', 'ASU offers a range of undergraduate and graduate programs in business and law, with a strong emphasis on applied learning and practical skills.', 'Jordan', 'Amman', 'https://goo.gl/maps/example68', 'info@asu.edu.jo', '0794343434', NULL, 'https://asu.edu.jo', NULL, NULL, NULL, 'assets/images/places/edu/edu(14).jpg', '2025-03-15 14:45:27'),
(103, 30, 10, 'Middle East University', '$$$', 'University, Private, International', 'MEU offers a wide range of programs in arts, engineering, and social sciences, with a strong focus on international education and research opportunities.', 'Jordan', 'Amman', 'https://goo.gl/maps/example69', 'admissions@meu.edu.jo', '0794444444', NULL, 'https://meu.edu.jo', 'https://facebook.com/meu.edu.jo', 'https://instagram.com/meu.edu.jo', NULL, 'assets/images/places/edu/edu(15).jpg', '2025-03-15 14:45:27'),
(104, 2, 11, 'Jordan Hospital', '$$$', 'Hospital, Medical Services, Emergency Care', 'Jordan Hospital offers comprehensive medical services, including emergency care, specialized treatments, and advanced diagnostics.', 'Jordan', 'Amman', 'https://goo.gl/maps/example70', 'info@jordanhospital.com', '0795050505', NULL, 'https://jordanhospital.com', 'https://facebook.com/jordanhospital', 'https://instagram.com/jordanhospital', NULL, 'assets/images/places/health/h(1).jpg', '2025-03-15 14:46:39'),
(105, 4, 11, 'Al-Bashir Hospital', '$$', 'Hospital, Public, Emergency Services', 'Al-Bashir Hospital is the largest public hospital in Jordan, providing emergency, diagnostic, and inpatient services to the local population.', 'Jordan', 'Amman', 'https://goo.gl/maps/example71', 'info@bashirhospital.jo', '0795151515', NULL, 'https://bashirhospital.jo', NULL, NULL, NULL, 'assets/images/places/health/h(2).jpg', '2025-03-15 14:46:39'),
(106, 6, 11, 'King Hussein Cancer Center', '$$$', 'Cancer Care, Research, Hospital', 'The King Hussein Cancer Center is a leading treatment and research center in the Middle East, specializing in cancer care and therapies.', 'Jordan', 'Amman', 'https://goo.gl/maps/example72', 'info@khcc.jo', '0795252525', NULL, 'https://khcc.jo', 'https://facebook.com/khcc.jo', 'https://instagram.com/khcc.jo', NULL, 'assets/images/places/health/h(3).jpg', '2025-03-15 14:46:39'),
(107, 8, 11, 'Specialized Medical Center', '$$$', 'Medical Center, Specialized, Clinics', 'The Specialized Medical Center offers high-quality healthcare with specialized clinics in cardiology, neurology, and orthopedics.', 'Jordan', 'Amman', 'https://goo.gl/maps/example73', 'info@smc.jo', '0795353535', '0797676767', 'https://smc.jo', 'https://facebook.com/specializedmedicalcenter', 'https://instagram.com/specializedmedicalcenter', 'https://x.com/home', 'assets/images/places/health/h(4).jpg', '2025-03-15 14:46:39'),
(108, 10, 11, 'Al-Esra Hospital', '$$', 'Hospital, General Health, Maternity', 'Al-Esra Hospital provides comprehensive healthcare services, with specialized departments in maternity, general medicine, and surgery.', 'Jordan', 'Amman', 'https://goo.gl/maps/example74', 'info@alesrahospital.com', '0795454545', NULL, 'https://alesrahospital.com', NULL, NULL, NULL, 'assets/images/places/health/h(5).jpg', '2025-03-15 14:46:39'),
(109, 12, 11, 'Abdali Hospital', '$$$', 'Hospital, Luxury Care, Rehabilitation', 'Abdali Hospital is known for offering luxury healthcare with advanced rehabilitation services, including physiotherapy and recovery programs.', 'Jordan', 'Amman', 'https://goo.gl/maps/example75', 'info@abdalihospital.com', '0795555555', NULL, 'https://abdalihospital.com', 'https://facebook.com/abdalihospital', 'https://instagram.com/abdalihospital', NULL, 'assets/images/places/health/h(6).jpg', '2025-03-15 14:46:39'),
(110, 14, 11, 'Arab Medical Center', '$$', 'Medical Center, Private, Family Care', 'The Arab Medical Center offers a range of private healthcare services, specializing in family medicine, dentistry, and pediatric care.', 'Jordan', 'Amman', 'https://goo.gl/maps/example76', 'info@amc.jo', '0795656565', NULL, 'https://amc.jo', NULL, NULL, 'https://x.com/home', 'assets/images/places/health/h(7).jpg', '2025-03-15 14:46:39'),
(111, 16, 11, 'Maternity and Child Hospital', '$$', 'Hospital, Maternity, Pediatrics', 'The Maternity and Child Hospital provides specialized care for women and children, focusing on prenatal, postnatal, and pediatric health.', 'Jordan', 'Amman', 'https://goo.gl/maps/example77', 'info@mch.jo', '0795757575', NULL, 'https://mch.jo', NULL, NULL, NULL, 'assets/images/places/health/h(8).jpg', '2025-03-15 14:46:39'),
(112, 18, 11, 'Al-Kindi Hospital', '$$', 'Hospital, General Medicine, Surgery', 'Al-Kindi Hospital offers a wide range of healthcare services, including general medicine, surgery, and diagnostic testing.', 'Jordan', 'Amman', 'https://goo.gl/maps/example78', 'info@kindihospital.com', '0795858585', NULL, 'https://kindihospital.com', NULL, NULL, NULL, 'assets/images/places/health/h(9).jpg', '2025-03-15 14:46:39'),
(113, 20, 11, 'Jordan Heart Center', '$$$', 'Medical Center, Cardiology, Heart Care', 'Jordan Heart Center is a leading provider of cardiology services, offering heart surgery, diagnostic tests, and post-treatment care.', 'Jordan', 'Amman', 'https://goo.gl/maps/example79', 'info@jordanheartcenter.com', '0795959595', '0797676767', 'https://jordanheartcenter.com', 'https://facebook.com/jordanheartcenter', 'https://instagram.com/jordanheartcenter', 'https://x.com/home', 'assets/images/places/health/h(10).jpg', '2025-03-15 14:46:39'),
(114, 22, 11, 'Noor Al-Hussein Cancer Center', '$$$', 'Cancer Treatment, Medical Research', 'Noor Al-Hussein Cancer Center provides advanced cancer treatments and has a renowned research department for the latest medical breakthroughs.', 'Jordan', 'Amman', 'https://goo.gl/maps/example80', 'info@nhcc.jo', '0796060606', '0797676767', 'https://nhcc.jo', NULL, NULL, NULL, 'assets/images/places/health/h(11).jpg', '2025-03-15 14:46:39'),
(115, 24, 11, 'The Islamic Hospital', '$$', 'Hospital, General Care, Surgery', 'The Islamic Hospital offers general medical care, emergency services, and specialized surgical treatments.', 'Jordan', 'Amman', 'https://goo.gl/maps/example81', 'info@islamichospital.com', '0796161616', NULL, 'https://islamichospital.com', NULL, NULL, NULL, 'assets/images/places/health/h(12).jpg', '2025-03-15 14:46:39'),
(116, 26, 11, 'Royal Medical Services', '$$$', 'Military Hospital, General Care, Surgery', 'Royal Medical Services serves Jordan’s military personnel and offers general medical care, emergency services, and specialized surgeries.', 'Jordan', 'Amman', 'https://goo.gl/maps/example82', 'info@royalmedservices.jo', '0796262626', '0797676767', 'https://royalmedservices.jo', NULL, NULL, NULL, 'assets/images/places/health/h(13).jpg', '2025-03-15 14:46:39'),
(117, 28, 11, 'Al-Bashir Health Center', '$$', 'Health Center, Public, Family Medicine', 'A health center offering a wide range of public healthcare services, including family medicine, vaccinations, and general checkups.', 'Jordan', 'Amman', 'https://goo.gl/maps/example83', 'info@bashirhealthcenter.jo', '0796363636', NULL, 'https://bashirhealthcenter.jo', NULL, NULL, NULL, 'assets/images/places/health/h(14).jpg', '2025-03-15 14:46:39'),
(118, 1, 12, 'Co-Work Hub', '$$', 'Workspace, Co-Working, Offices', 'Co-Work Hub is a modern co-working space offering flexible office solutions, meeting rooms, and collaboration opportunities for startups and entrepreneurs.', 'Jordan', 'Amman', 'https://goo.gl/maps/example84', 'info@coworkhub.jo', '0796464646', NULL, 'https://coworkhub.jo', NULL, NULL, NULL, 'assets/images/places/workspace/work(1).jpg', '2025-03-15 14:47:35'),
(119, 3, 12, 'The Office', '$$$', 'Workspace, Premium Offices, Events', 'The Office offers premium office spaces with advanced facilities, ideal for businesses looking for a professional and creative environment.', 'Jordan', 'Amman', 'https://goo.gl/maps/example85', 'contact@theoffice.jo', '0796565656', NULL, 'https://theoffice.jo', 'https://facebook.com/theoffice.jo', 'https://instagram.com/theoffice.jo', NULL, 'assets/images/places/workspace/work(2).jpg', '2025-03-15 14:47:35'),
(120, 7, 12, 'Flexi Spaces', '$$', 'Workspace, Shared Offices, Flexible Plans', 'Flexi Spaces offers shared offices with flexible plans, giving companies the ability to scale their workspace according to needs.', 'Jordan', 'Amman', 'https://goo.gl/maps/example86', 'info@flexispaces.jo', '0796666666', NULL, 'https://flexispaces.jo', NULL, NULL, NULL, 'assets/images/places/workspace/work(3).jpg', '2025-03-15 14:47:35'),
(121, 9, 12, 'Startup Space', '$$', 'Workspace, Co-Working, Networking', 'Startup Space is designed for startups and small businesses, providing co-working areas, networking opportunities, and business support services.', 'Jordan', 'Amman', 'https://goo.gl/maps/example87', 'info@startupspace.jo', '0796767676', NULL, 'https://startupspace.jo', NULL, NULL, 'https://x.com/home', 'assets/images/places/workspace/work(4).jpg', '2025-03-15 14:47:35');
INSERT INTO `places` (`id`, `user_id`, `category_id`, `name`, `price`, `tags`, `highlights`, `country`, `city`, `google_map_location`, `email`, `phone_1`, `phone_2`, `website`, `facebook_url`, `instagram_url`, `twitter_url`, `featured_image`, `created_at`) VALUES
(122, 11, 12, 'Co-Work Jordan', '$$', 'Workspace, Shared Offices, Startups', 'Co-Work Jordan offers shared office spaces for entrepreneurs, freelancers, and small teams, fostering collaboration and business growth.', 'Jordan', 'Amman', 'https://goo.gl/maps/example88', 'info@coworkjordan.com', '0796868686', NULL, 'https://coworkjordan.com', NULL, NULL, NULL, 'assets/images/places/workspace/work(5).jpg', '2025-03-15 14:47:35'),
(123, 13, 12, 'The Foundry', '$$$', 'Workspace, Premium Offices, Networking', 'The Foundry is a co-working space offering private offices, shared desks, and events for business professionals and entrepreneurs.', 'Jordan', 'Amman', 'https://goo.gl/maps/example89', 'contact@thefoundry.jo', '0796969696', '0797676767', 'https://thefoundry.jo', 'https://facebook.com/thefoundry.jo', 'https://instagram.com/thefoundry.jo', 'https://x.com/home', 'assets/images/places/workspace/work(6).jpg', '2025-03-15 14:47:35'),
(124, 15, 12, 'Hub 25', '$$', 'Workspace, Shared Offices, Creative', 'Hub 25 offers flexible co-working spaces for creatives, startups, and freelancers, with high-speed internet, meeting rooms, and community events.', 'Jordan', 'Amman', 'https://goo.gl/maps/example90', 'info@hub25.jo', '0797070707', NULL, 'https://hub25.jo', NULL, NULL, NULL, 'assets/images/places/workspace/work(7).jpg', '2025-03-15 14:47:35'),
(125, 17, 12, 'SpaceWorks', '$$', 'Workspace, Collaboration, Shared Offices', 'SpaceWorks provides an inspiring and collaborative workspace environment with open desks, meeting rooms, and creative workshops.', 'Jordan', 'Amman', 'https://goo.gl/maps/example91', 'info@spaceworks.jo', '0797171717', NULL, 'https://spaceworks.jo', NULL, NULL, NULL, 'assets/images/places/workspace/work(8).jpg', '2025-03-15 14:47:35'),
(126, 19, 12, 'The Incubator', '$$$', 'Workspace, Accelerator, Shared Offices', 'The Incubator is a premium co-working space aimed at supporting startups and providing acceleration services for growing businesses.', 'Jordan', 'Amman', 'https://goo.gl/maps/example92', 'info@theincubator.jo', '0797272727', NULL, 'https://theincubator.jo', NULL, NULL, NULL, 'assets/images/places/workspace/work(9).jpg', '2025-03-15 14:47:35'),
(127, 21, 12, 'WorkHub', '$$', 'Workspace, Co-Working, Freelancers', 'WorkHub offers dedicated desks and private offices for freelancers and small businesses, with a variety of flexible membership plans.', 'Jordan', 'Amman', 'https://goo.gl/maps/example93', 'info@workhub.jo', '0797373737', NULL, 'https://workhub.jo', NULL, NULL, NULL, 'assets/images/places/workspace/work(10).jpg', '2025-03-15 14:47:35'),
(128, 23, 12, 'Collaborative Space', '$$', 'Workspace, Shared Offices, Networking', 'Collaborative Space offers open desks, private offices, and event spaces, creating a hub for collaboration and innovation.', 'Jordan', 'Amman', 'https://goo.gl/maps/example94', 'info@collaborativespace.jo', '0797474747', NULL, 'https://collaborativespace.jo', NULL, NULL, NULL, 'assets/images/places/workspace/work(11).jpg', '2025-03-15 14:47:35'),
(129, 25, 12, 'CoWork +', '$$', 'Workspace, Flexible, Networking', 'CoWork + provides flexible office spaces with all the amenities needed for entrepreneurs, remote workers, and small businesses.', 'Jordan', 'Amman', 'https://goo.gl/maps/example95', 'info@coworkplus.jo', '0797575757', '0797676767', 'https://coworkplus.jo', NULL, NULL, NULL, 'assets/images/places/workspace/work(14).jpg', '2025-03-15 14:47:35'),
(130, 27, 12, 'The Business Hub', '$$$', 'Workspace, Business Support, Office Spaces', 'The Business Hub offers a professional environment with fully equipped office spaces and business support services, ideal for corporations and entrepreneurs.', 'Jordan', 'Amman', 'https://goo.gl/maps/example96', 'info@businesshub.jo', '0797676767', NULL, 'https://businesshub.jo', NULL, NULL, 'https://x.com/home', 'assets/images/places/workspace/work(15).jpg', '2025-03-15 14:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `place_gallery`
--

CREATE TABLE `place_gallery` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `place_gallery`
--

INSERT INTO `place_gallery` (`id`, `place_id`, `image_url`) VALUES
(1, 1, 'assets/images/places/restaurants/R(1).jpg'),
(2, 1, 'assets/images/places/restaurants/R(2).jpg'),
(3, 1, 'assets/images/places/restaurants/R(3).jpg'),
(4, 2, 'assets/images/places/restaurants/R(4).jpg'),
(5, 2, 'assets/images/places/restaurants/R(5).jpg'),
(6, 2, 'assets/images/places/restaurants/R(6).jpg'),
(7, 3, 'assets/images/places/restaurants/R(7).jpg'),
(8, 3, 'assets/images/places/restaurants/R(8).jpg'),
(9, 3, 'assets/images/places/restaurants/R(9).jpg'),
(10, 4, 'assets/images/places/restaurants/R(10).jpg'),
(11, 4, 'assets/images/places/restaurants/R(11).jpg'),
(12, 4, 'assets/images/places/restaurants/R(12).jpg'),
(13, 5, 'assets/images/places/restaurants/R(13).jpg'),
(14, 5, 'assets/images/places/restaurants/R(14).jpg'),
(15, 5, 'assets/images/places/restaurants/R(15).jpg'),
(16, 6, 'assets/images/places/restaurants/R(16).jpg'),
(17, 6, 'assets/images/places/restaurants/R(17).jpg'),
(18, 6, 'assets/images/places/restaurants/R(18).jpg'),
(19, 7, 'assets/images/places/restaurants/R(19).jpg'),
(20, 7, 'assets/images/places/restaurants/R(20).jpg'),
(21, 7, 'assets/images/places/restaurants/R(1).jpg'),
(22, 8, 'assets/images/places/restaurants/R(2).jpg'),
(23, 8, 'assets/images/places/restaurants/R(3).jpg'),
(24, 8, 'assets/images/places/restaurants/R(4).jpg'),
(25, 1, 'assets/images/places/restaurants/RM(1).jpg'),
(26, 2, 'assets/images/places/restaurants/RM(2).jpg'),
(27, 3, 'assets/images/places/restaurants/RM(3).jpg'),
(28, 4, 'assets/images/places/restaurants/RM(4).jpg'),
(29, 5, 'assets/images/places/restaurants/RM(5).jpg'),
(30, 6, 'assets/images/places/restaurants/RM(6).jpg'),
(31, 7, 'assets/images/places/restaurants/RM(7).jpg'),
(32, 8, 'assets/images/places/restaurants/RM(8).jpg'),
(33, 9, 'assets/images/places/shopping/sh(1).jpg'),
(34, 9, 'assets/images/places/shopping/sh(2).jpg'),
(35, 9, 'assets/images/places/shopping/sh(3).jpg'),
(36, 9, 'assets/images/places/shopping/sh(4).jpg'),
(37, 9, 'assets/images/places/shopping/sh(5).jpg'),
(38, 10, 'assets/images/places/shopping/sh(6).jpg'),
(39, 10, 'assets/images/places/shopping/sh(7).jpg'),
(40, 10, 'assets/images/places/shopping/sh(8).jpg'),
(41, 10, 'assets/images/places/shopping/sh(9).jpg'),
(42, 10, 'assets/images/places/shopping/sh(10).jpg'),
(43, 11, 'assets/images/places/shopping/sh(11).jpg'),
(44, 11, 'assets/images/places/shopping/sh(12).jpg'),
(45, 11, 'assets/images/places/shopping/sh(13).jpg'),
(46, 11, 'assets/images/places/shopping/sh(14).jpg'),
(47, 11, 'assets/images/places/shopping/sh(15).jpg'),
(48, 12, 'assets/images/places/shopping/sh(16).jpg'),
(49, 12, 'assets/images/places/shopping/sh(17).jpg'),
(50, 12, 'assets/images/places/shopping/sh(18).jpg'),
(51, 12, 'assets/images/places/shopping/sh(19).jpg'),
(52, 12, 'assets/images/places/shopping/sh(20).jpg'),
(53, 13, 'assets/images/places/shopping/sh(21).jpg'),
(54, 13, 'assets/images/places/shopping/sh(22).jpg'),
(55, 13, 'assets/images/places/shopping/sh(23).jpg'),
(56, 13, 'assets/images/places/shopping/sh(24).jpg'),
(57, 13, 'assets/images/places/shopping/sh(25).jpg'),
(58, 14, 'assets/images/places/shopping/sh(26).jpg'),
(59, 14, 'assets/images/places/shopping/sh(27).jpg'),
(60, 14, 'assets/images/places/shopping/sh(28).jpg'),
(61, 14, 'assets/images/places/shopping/sh(29).jpg'),
(62, 14, 'assets/images/places/shopping/sh(1).jpg'),
(63, 15, 'assets/images/places/shopping/sh(2).jpg'),
(64, 15, 'assets/images/places/shopping/sh(3).jpg'),
(65, 15, 'assets/images/places/shopping/sh(4).jpg'),
(66, 15, 'assets/images/places/shopping/sh(5).jpg'),
(67, 15, 'assets/images/places/shopping/sh(6).jpg'),
(68, 16, 'assets/images/places/shopping/sh(7).jpg'),
(69, 16, 'assets/images/places/shopping/sh(8).jpg'),
(70, 16, 'assets/images/places/shopping/sh(9).jpg'),
(71, 16, 'assets/images/places/shopping/sh(10).jpg'),
(72, 16, 'assets/images/places/shopping/sh(11).jpg'),
(73, 17, 'assets/images/places/active-life/a(1).jpg'),
(74, 17, 'assets/images/places/active-life/a(2).jpg'),
(75, 17, 'assets/images/places/active-life/a(3).jpg'),
(76, 17, 'assets/images/places/active-life/a(4).jpg'),
(77, 17, 'assets/images/places/active-life/a(5).jpg'),
(78, 18, 'assets/images/places/active-life/a(6).jpg'),
(79, 18, 'assets/images/places/active-life/a(7).jpg'),
(80, 18, 'assets/images/places/active-life/a(8).jpg'),
(81, 18, 'assets/images/places/active-life/a(9).jpg'),
(82, 18, 'assets/images/places/active-life/a(10).jpg'),
(83, 19, 'assets/images/places/active-life/a(11).jpg'),
(84, 19, 'assets/images/places/active-life/a(12).jpg'),
(85, 19, 'assets/images/places/active-life/a(13).jpg'),
(86, 19, 'assets/images/places/active-life/a(14).jpg'),
(87, 19, 'assets/images/places/active-life/a(15).jpg'),
(88, 20, 'assets/images/places/active-life/a(16).jpg'),
(89, 20, 'assets/images/places/active-life/a(17).jpg'),
(90, 20, 'assets/images/places/active-life/a(18).jpg'),
(91, 20, 'assets/images/places/active-life/a(19).jpg'),
(92, 20, 'assets/images/places/active-life/a(20).jpg'),
(93, 21, 'assets/images/places/active-life/a(1).jpg'),
(94, 21, 'assets/images/places/active-life/a(2).jpg'),
(95, 21, 'assets/images/places/active-life/a(3).jpg'),
(96, 21, 'assets/images/places/active-life/a(4).jpg'),
(97, 21, 'assets/images/places/active-life/a(5).jpg'),
(98, 22, 'assets/images/places/active-life/a(6).jpg'),
(99, 22, 'assets/images/places/active-life/a(7).jpg'),
(100, 22, 'assets/images/places/active-life/a(8).jpg'),
(101, 22, 'assets/images/places/active-life/a(9).jpg'),
(102, 22, 'assets/images/places/active-life/a(10).jpg'),
(103, 23, 'assets/images/places/home s/h(1).jpg'),
(104, 23, 'assets/images/places/home s/h(2).jpg'),
(105, 23, 'assets/images/places/home s/h(3).jpg'),
(106, 23, 'assets/images/places/home s/h(4).jpg'),
(107, 23, 'assets/images/places/home s/h(5).jpg'),
(108, 24, 'assets/images/places/home s/h(6).jpg'),
(109, 24, 'assets/images/places/home s/h(7).jpg'),
(110, 24, 'assets/images/places/home s/h(8).jpg'),
(111, 24, 'assets/images/places/home s/h(9).jpg'),
(112, 24, 'assets/images/places/home s/h(10).jpg'),
(113, 25, 'assets/images/places/home s/h(11).jpg'),
(114, 25, 'assets/images/places/home s/h(12).jpg'),
(115, 25, 'assets/images/places/home s/h(13).jpg'),
(116, 25, 'assets/images/places/home s/h(14).jpg'),
(117, 25, 'assets/images/places/home s/h(15).jpg'),
(118, 26, 'assets/images/places/home s/h(16).jpg'),
(119, 26, 'assets/images/places/home s/h(17).jpg'),
(120, 26, 'assets/images/places/home s/h(18).jpg'),
(121, 26, 'assets/images/places/home s/h(19).jpg'),
(122, 26, 'assets/images/places/home s/h(20).jpg'),
(123, 27, 'assets/images/places/home s/h(21).jpg'),
(124, 27, 'assets/images/places/home s/h(22).jpg'),
(125, 27, 'assets/images/places/home s/h(23).jpg'),
(126, 27, 'assets/images/places/home s/h(24).jpg'),
(127, 27, 'assets/images/places/home s/h(25).jpg'),
(128, 28, 'assets/images/places/home s/h(26).jpg'),
(129, 28, 'assets/images/places/home s/h(27).jpg'),
(130, 28, 'assets/images/places/home s/h(28).jpg'),
(131, 28, 'assets/images/places/home s/h(29).jpg'),
(132, 28, 'assets/images/places/home s/h(30).jpg'),
(133, 29, 'assets/images/places/home s/h(31).jpg'),
(134, 29, 'assets/images/places/home s/h(32).jpg'),
(135, 29, 'assets/images/places/home s/h(33).jpg'),
(136, 29, 'assets/images/places/home s/h(34).jpg'),
(137, 29, 'assets/images/places/home s/h(35).jpg'),
(138, 30, 'assets/images/places/home s/h(36).jpg'),
(139, 30, 'assets/images/places/home s/h(37).jpg'),
(140, 30, 'assets/images/places/home s/h(38).jpg'),
(141, 30, 'assets/images/places/home s/h(39).jpg'),
(142, 30, 'assets/images/places/home s/h(40).jpg'),
(143, 31, 'assets/images/places/home s/h(41).jpg'),
(144, 31, 'assets/images/places/home s/h(42).jpg'),
(145, 31, 'assets/images/places/home s/h(43).jpg'),
(146, 31, 'assets/images/places/home s/h(44).jpg'),
(147, 31, 'assets/images/places/home s/h(45).jpg'),
(148, 32, 'assets/images/places/home s/h(46).jpg'),
(149, 32, 'assets/images/places/home s/h(47).jpg'),
(150, 32, 'assets/images/places/home s/h(48).jpg'),
(151, 32, 'assets/images/places/home s/h(49).jpg'),
(152, 32, 'assets/images/places/home s/h(50).jpg'),
(153, 33, 'assets/images/places/home s/h(51).jpg'),
(154, 33, 'assets/images/places/home s/h(52).jpg'),
(155, 33, 'assets/images/places/home s/h(53).jpg'),
(156, 34, 'assets/images/places/home s/h(1).jpg'),
(157, 34, 'assets/images/places/home s/h(2).jpg'),
(158, 34, 'assets/images/places/home s/h(3).jpg'),
(159, 34, 'assets/images/places/home s/h(4).jpg'),
(160, 34, 'assets/images/places/home s/h(5).jpg'),
(161, 35, 'assets/images/places/Coffee/c(1).jpg'),
(162, 35, 'assets/images/places/Coffee/c(2).jpg'),
(163, 35, 'assets/images/places/Coffee/c(3).jpg'),
(164, 35, 'assets/images/places/Coffee/c(4).jpg'),
(165, 35, 'assets/images/places/Coffee/c(5).jpg'),
(166, 36, 'assets/images/places/Coffee/c(6).jpg'),
(167, 36, 'assets/images/places/Coffee/c(7).jpg'),
(168, 36, 'assets/images/places/Coffee/c(8).jpg'),
(169, 36, 'assets/images/places/Coffee/c(9).jpg'),
(170, 36, 'assets/images/places/Coffee/c(10).jpg'),
(171, 37, 'assets/images/places/Coffee/c(11).jpg'),
(172, 37, 'assets/images/places/Coffee/c(12).jpg'),
(173, 37, 'assets/images/places/Coffee/c(13).jpg'),
(174, 37, 'assets/images/places/Coffee/c(14).jpg'),
(175, 37, 'assets/images/places/Coffee/c(15).jpg'),
(176, 38, 'assets/images/places/Coffee/c(16).jpg'),
(177, 38, 'assets/images/places/Coffee/c(17).jpg'),
(178, 38, 'assets/images/places/Coffee/c(18).jpg'),
(179, 38, 'assets/images/places/Coffee/c(19).jpg'),
(180, 38, 'assets/images/places/Coffee/c(20).jpg'),
(181, 39, 'assets/images/places/Coffee/c(21).jpg'),
(182, 39, 'assets/images/places/Coffee/c(22).jpg'),
(183, 39, 'assets/images/places/Coffee/c(23).jpg'),
(184, 39, 'assets/images/places/Coffee/c(24).jpg'),
(185, 39, 'assets/images/places/Coffee/c(25).jpg'),
(186, 40, 'assets/images/places/Coffee/c(26).jpg'),
(187, 40, 'assets/images/places/Coffee/c(27).jpg'),
(188, 40, 'assets/images/places/Coffee/c(28).jpg'),
(189, 40, 'assets/images/places/Coffee/c(29).jpg'),
(190, 40, 'assets/images/places/Coffee/c(30).jpg'),
(191, 41, 'assets/images/places/Coffee/c(31).jpg'),
(192, 41, 'assets/images/places/Coffee/c(32).jpg'),
(193, 41, 'assets/images/places/Coffee/c(33).jpg'),
(194, 41, 'assets/images/places/Coffee/c(34).jpg'),
(195, 41, 'assets/images/places/Coffee/c(35).jpg'),
(196, 42, 'assets/images/places/Coffee/c(36).jpg'),
(197, 42, 'assets/images/places/Coffee/c(37).jpg'),
(198, 42, 'assets/images/places/Coffee/c(38).jpg'),
(199, 42, 'assets/images/places/Coffee/c(39).jpg'),
(200, 42, 'assets/images/places/Coffee/c(40).jpg'),
(201, 43, 'assets/images/places/Coffee/c(41).jpg'),
(202, 43, 'assets/images/places/Coffee/c(42).jpg'),
(203, 43, 'assets/images/places/Coffee/c(43).jpg'),
(204, 43, 'assets/images/places/Coffee/c(44).jpg'),
(205, 43, 'assets/images/places/Coffee/c(45).jpg'),
(206, 44, 'assets/images/places/Coffee/c(46).jpg'),
(207, 44, 'assets/images/places/Coffee/c(47).jpg'),
(208, 44, 'assets/images/places/Coffee/c(48).jpg'),
(209, 44, 'assets/images/places/Coffee/c(49).jpg'),
(210, 44, 'assets/images/places/Coffee/c(50).jpg'),
(211, 45, 'assets/images/places/Coffee/c(1).jpg'),
(212, 45, 'assets/images/places/Coffee/c(2).jpg'),
(213, 45, 'assets/images/places/Coffee/c(3).jpg'),
(214, 45, 'assets/images/places/Coffee/c(4).jpg'),
(215, 45, 'assets/images/places/Coffee/c(5).jpg'),
(216, 46, 'assets/images/places/Coffee/c(6).jpg'),
(217, 46, 'assets/images/places/Coffee/c(7).jpg'),
(218, 46, 'assets/images/places/Coffee/c(8).jpg'),
(219, 46, 'assets/images/places/Coffee/c(9).jpg'),
(220, 46, 'assets/images/places/Coffee/c(10).jpg'),
(221, 47, 'assets/images/places/Coffee/c(11).jpg'),
(222, 47, 'assets/images/places/Coffee/c(12).jpg'),
(223, 47, 'assets/images/places/Coffee/c(13).jpg'),
(224, 47, 'assets/images/places/Coffee/c(14).jpg'),
(225, 47, 'assets/images/places/Coffee/c(15).jpg'),
(226, 48, 'assets/images/places/Coffee/c(1).jpg'),
(227, 48, 'assets/images/places/Coffee/c(2).jpg'),
(228, 48, 'assets/images/places/Coffee/c(3).jpg'),
(229, 48, 'assets/images/places/Coffee/c(4).jpg'),
(230, 48, 'assets/images/places/Coffee/c(5).jpg'),
(231, 49, 'assets/images/places/Coffee/c(6).jpg'),
(232, 49, 'assets/images/places/Coffee/c(7).jpg'),
(233, 49, 'assets/images/places/Coffee/c(8).jpg'),
(234, 49, 'assets/images/places/Coffee/c(9).jpg'),
(235, 49, 'assets/images/places/Coffee/c(10).jpg'),
(236, 50, 'assets/images/places/pets/pets(1).jpg'),
(237, 50, 'assets/images/places/pets/pets(2).jpg'),
(238, 50, 'assets/images/places/pets/pets(3).jpg'),
(239, 50, 'assets/images/places/pets/pets(4).jpg'),
(240, 50, 'assets/images/places/pets/pets(5).jpg'),
(241, 51, 'assets/images/places/pets/pets(6).jpg'),
(242, 51, 'assets/images/places/pets/pets(7).jpg'),
(243, 51, 'assets/images/places/pets/pets(8).jpg'),
(244, 51, 'assets/images/places/pets/pets(9).jpg'),
(245, 51, 'assets/images/places/pets/pets(10).jpg'),
(246, 52, 'assets/images/places/pets/pets(11).jpg'),
(247, 52, 'assets/images/places/pets/pets(12).jpg'),
(248, 52, 'assets/images/places/pets/pets(13).jpg'),
(249, 52, 'assets/images/places/pets/pets(14).jpg'),
(250, 52, 'assets/images/places/pets/pets(15).jpg'),
(251, 53, 'assets/images/places/pets/pets(16).jpg'),
(252, 53, 'assets/images/places/pets/pets(17).jpg'),
(253, 53, 'assets/images/places/pets/pets(18).jpg'),
(254, 53, 'assets/images/places/pets/pets(19).jpg'),
(255, 53, 'assets/images/places/pets/pets(20).jpg'),
(256, 54, 'assets/images/places/pets/pets(21).jpg'),
(257, 54, 'assets/images/places/pets/pets(22).jpg'),
(258, 54, 'assets/images/places/pets/pets(23).jpg'),
(259, 54, 'assets/images/places/pets/pets(24).jpg'),
(260, 54, 'assets/images/places/pets/pets(25).jpg'),
(261, 55, 'assets/images/places/pets/pets(26).jpg'),
(262, 55, 'assets/images/places/pets/pets(27).jpg'),
(263, 55, 'assets/images/places/pets/pets(28).jpg'),
(264, 55, 'assets/images/places/pets/pets(29).jpg'),
(265, 55, 'assets/images/places/pets/pets(30).jpg'),
(266, 56, 'assets/images/places/pets/pets(31).jpg'),
(267, 56, 'assets/images/places/pets/pets(32).jpg'),
(268, 56, 'assets/images/places/pets/pets(1).jpg'),
(269, 56, 'assets/images/places/pets/pets(2).jpg'),
(270, 56, 'assets/images/places/pets/pets(3).jpg'),
(271, 57, 'assets/images/places/pets/pets(4).jpg'),
(272, 57, 'assets/images/places/pets/pets(5).jpg'),
(273, 57, 'assets/images/places/pets/pets(6).jpg'),
(274, 57, 'assets/images/places/pets/pets(7).jpg'),
(275, 57, 'assets/images/places/pets/pets(8).jpg'),
(276, 58, 'assets/images/places/plants/plants(1).jpg'),
(277, 58, 'assets/images/places/plants/plants(2).jpg'),
(278, 58, 'assets/images/places/plants/plants(3).jpg'),
(279, 58, 'assets/images/places/plants/plants(4).jpg'),
(280, 58, 'assets/images/places/plants/plants(5).jpg'),
(281, 59, 'assets/images/places/plants/plants(6).jpg'),
(282, 59, 'assets/images/places/plants/plants(7).jpg'),
(283, 59, 'assets/images/places/plants/plants(8).jpg'),
(284, 59, 'assets/images/places/plants/plants(9).jpg'),
(285, 59, 'assets/images/places/plants/plants(10).jpg'),
(286, 60, 'assets/images/places/plants/plants(11).jpg'),
(287, 60, 'assets/images/places/plants/plants(12).jpg'),
(288, 60, 'assets/images/places/plants/plants(13).jpg'),
(289, 60, 'assets/images/places/plants/plants(14).jpg'),
(290, 60, 'assets/images/places/plants/plants(15).jpg'),
(291, 61, 'assets/images/places/plants/plants(16).jpg'),
(292, 61, 'assets/images/places/plants/plants(17).jpg'),
(293, 61, 'assets/images/places/plants/plants(18).jpg'),
(294, 61, 'assets/images/places/plants/plants(19).jpg'),
(295, 61, 'assets/images/places/plants/plants(20).jpg'),
(296, 62, 'assets/images/places/plants/plants(21).jpg'),
(297, 62, 'assets/images/places/plants/plants(22).jpg'),
(298, 62, 'assets/images/places/plants/plants(23).jpg'),
(299, 62, 'assets/images/places/plants/plants(24).jpg'),
(300, 62, 'assets/images/places/plants/plants(25).jpg'),
(301, 63, 'assets/images/places/plants/plants(26).jpg'),
(302, 63, 'assets/images/places/plants/plants(27).jpg'),
(303, 63, 'assets/images/places/plants/plants(28).jpg'),
(304, 63, 'assets/images/places/plants/plants(29).jpg'),
(305, 63, 'assets/images/places/plants/plants(30).jpg'),
(306, 64, 'assets/images/places/plants/plants(31).jpg'),
(307, 64, 'assets/images/places/plants/plants(32).jpg'),
(308, 64, 'assets/images/places/plants/plants(33).jpg'),
(309, 64, 'assets/images/places/plants/plants(34).jpg'),
(310, 64, 'assets/images/places/plants/plants(35).jpg'),
(311, 65, 'assets/images/places/plants/plants(36).jpg'),
(312, 65, 'assets/images/places/plants/plants(37).jpg'),
(313, 65, 'assets/images/places/plants/plants(38).jpg'),
(314, 65, 'assets/images/places/plants/plants(39).jpg'),
(315, 65, 'assets/images/places/plants/plants(40).jpg'),
(316, 66, 'assets/images/places/art/art(1).jpg'),
(317, 66, 'assets/images/places/art/art(2).jpg'),
(318, 66, 'assets/images/places/art/art(3).jpg'),
(319, 66, 'assets/images/places/art/art(4).jpg'),
(320, 66, 'assets/images/places/art/art(5).jpg'),
(321, 67, 'assets/images/places/art/art(6).jpg'),
(322, 67, 'assets/images/places/art/art(7).jpg'),
(323, 67, 'assets/images/places/art/art(8).jpg'),
(324, 67, 'assets/images/places/art/art(9).jpg'),
(325, 67, 'assets/images/places/art/art(10).jpg'),
(326, 68, 'assets/images/places/art/art(11).jpg'),
(327, 68, 'assets/images/places/art/art(12).jpg'),
(328, 68, 'assets/images/places/art/art(13).jpg'),
(329, 68, 'assets/images/places/art/art(14).jpg'),
(330, 68, 'assets/images/places/art/art(15).jpg'),
(331, 69, 'assets/images/places/art/art(16).jpg'),
(332, 69, 'assets/images/places/art/art(17).jpg'),
(333, 69, 'assets/images/places/art/art(18).jpg'),
(334, 69, 'assets/images/places/art/art(19).jpg'),
(335, 69, 'assets/images/places/art/art(20).jpg'),
(336, 70, 'assets/images/places/art/art(21).jpg'),
(337, 70, 'assets/images/places/art/art(22).jpg'),
(338, 70, 'assets/images/places/art/art(23).jpg'),
(339, 70, 'assets/images/places/art/art(24).jpg'),
(340, 70, 'assets/images/places/art/art(25).jpg'),
(341, 71, 'assets/images/places/art/art(26).jpg'),
(342, 71, 'assets/images/places/art/art(27).jpg'),
(343, 71, 'assets/images/places/art/art(28).jpg'),
(344, 71, 'assets/images/places/art/art(29).jpg'),
(345, 71, 'assets/images/places/art/art(30).jpg'),
(346, 72, 'assets/images/places/art/art(31).jpg'),
(347, 72, 'assets/images/places/art/art(32).jpg'),
(348, 72, 'assets/images/places/art/art(33).jpg'),
(349, 72, 'assets/images/places/art/art(34).jpg'),
(350, 72, 'assets/images/places/art/art(35).jpg'),
(351, 73, 'assets/images/places/art/art(36).jpg'),
(352, 73, 'assets/images/places/art/art(37).jpg'),
(353, 73, 'assets/images/places/art/art(38).jpg'),
(354, 73, 'assets/images/places/art/art(39).jpg'),
(355, 73, 'assets/images/places/art/art(1).jpg'),
(356, 74, 'assets/images/places/Hotel/hotel(1).jpg'),
(357, 74, 'assets/images/places/Hotel/hotel(2).jpg'),
(358, 74, 'assets/images/places/Hotel/hotel(3).jpg'),
(359, 74, 'assets/images/places/Hotel/hotel(4).jpg'),
(360, 74, 'assets/images/places/Hotel/hotel(5).jpg'),
(361, 75, 'assets/images/places/Hotel/hotel(6).jpg'),
(362, 75, 'assets/images/places/Hotel/hotel(7).jpg'),
(363, 75, 'assets/images/places/Hotel/hotel(8).jpg'),
(364, 75, 'assets/images/places/Hotel/hotel(9).jpg'),
(365, 75, 'assets/images/places/Hotel/hotel(10).jpg'),
(366, 76, 'assets/images/places/Hotel/hotel(11).jpg'),
(367, 76, 'assets/images/places/Hotel/hotel(12).jpg'),
(368, 76, 'assets/images/places/Hotel/hotel(13).jpg'),
(369, 76, 'assets/images/places/Hotel/hotel(14).jpg'),
(370, 76, 'assets/images/places/Hotel/hotel(15).jpg'),
(371, 77, 'assets/images/places/Hotel/hotel(16).jpg'),
(372, 77, 'assets/images/places/Hotel/hotel(17).jpg'),
(373, 77, 'assets/images/places/Hotel/hotel(18).jpg'),
(374, 77, 'assets/images/places/Hotel/hotel(19).jpg'),
(375, 77, 'assets/images/places/Hotel/hotel(20).jpg'),
(376, 78, 'assets/images/places/Hotel/hotel(21).jpg'),
(377, 78, 'assets/images/places/Hotel/hotel(22).jpg'),
(378, 78, 'assets/images/places/Hotel/hotel(23).jpg'),
(379, 78, 'assets/images/places/Hotel/hotel(24).jpg'),
(380, 78, 'assets/images/places/Hotel/hotel(25).jpg'),
(381, 79, 'assets/images/places/Hotel/hotel(26).jpg'),
(382, 79, 'assets/images/places/Hotel/hotel(27).jpg'),
(383, 79, 'assets/images/places/Hotel/hotel(28).jpg'),
(384, 79, 'assets/images/places/Hotel/hotel(29).jpg'),
(385, 79, 'assets/images/places/Hotel/hotel(30).jpg'),
(386, 80, 'assets/images/places/Hotel/hotel(31).jpg'),
(387, 80, 'assets/images/places/Hotel/hotel(32).jpg'),
(388, 80, 'assets/images/places/Hotel/hotel(33).jpg'),
(389, 80, 'assets/images/places/Hotel/hotel(34).jpg'),
(390, 80, 'assets/images/places/Hotel/hotel(35).jpg'),
(391, 81, 'assets/images/places/Hotel/hotel(36).jpg'),
(392, 81, 'assets/images/places/Hotel/hotel(37).jpg'),
(393, 81, 'assets/images/places/Hotel/hotel(38).jpg'),
(394, 81, 'assets/images/places/Hotel/hotel(39).jpg'),
(395, 81, 'assets/images/places/Hotel/hotel(40).jpg'),
(396, 82, 'assets/images/places/Hotel/hotel(41).jpg'),
(397, 82, 'assets/images/places/Hotel/hotel(42).jpg'),
(398, 82, 'assets/images/places/Hotel/hotel(43).jpg'),
(399, 82, 'assets/images/places/Hotel/hotel(44).jpg'),
(400, 82, 'assets/images/places/Hotel/hotel(45).jpg'),
(401, 83, 'assets/images/places/Hotel/hotel(46).jpg'),
(402, 83, 'assets/images/places/Hotel/hotel(47).jpg'),
(403, 83, 'assets/images/places/Hotel/hotel(48).jpg'),
(404, 83, 'assets/images/places/Hotel/hotel(49).jpg'),
(405, 83, 'assets/images/places/Hotel/hotel(50).jpg'),
(406, 84, 'assets/images/places/Hotel/hotel(51).jpg'),
(407, 84, 'assets/images/places/Hotel/hotel(52).jpg'),
(408, 84, 'assets/images/places/Hotel/hotel(53).jpg'),
(409, 84, 'assets/images/places/Hotel/hotel(54).jpg'),
(410, 84, 'assets/images/places/Hotel/hotel(55).jpg'),
(411, 85, 'assets/images/places/Hotel/hotel(56).jpg'),
(412, 85, 'assets/images/places/Hotel/hotel(57).jpg'),
(413, 85, 'assets/images/places/Hotel/hotel(58).jpg'),
(414, 85, 'assets/images/places/Hotel/hotel(59).jpg'),
(415, 85, 'assets/images/places/Hotel/hotel(60).jpg'),
(416, 86, 'assets/images/places/Hotel/hotel(61).jpg'),
(417, 86, 'assets/images/places/Hotel/hotel(1).jpg'),
(418, 86, 'assets/images/places/Hotel/hotel(2).jpg'),
(419, 86, 'assets/images/places/Hotel/hotel(3).jpg'),
(420, 86, 'assets/images/places/Hotel/hotel(4).jpg'),
(421, 87, 'assets/images/places/Hotel/hotel(5).jpg'),
(422, 87, 'assets/images/places/Hotel/hotel(6).jpg'),
(423, 87, 'assets/images/places/Hotel/hotel(7).jpg'),
(424, 87, 'assets/images/places/Hotel/hotel(8).jpg'),
(425, 87, 'assets/images/places/Hotel/hotel(9).jpg'),
(426, 88, 'assets/images/places/Hotel/hotel(10).jpg'),
(427, 88, 'assets/images/places/Hotel/hotel(11).jpg'),
(428, 88, 'assets/images/places/Hotel/hotel(12).jpg'),
(429, 88, 'assets/images/places/Hotel/hotel(13).jpg'),
(430, 88, 'assets/images/places/Hotel/hotel(14).jpg'),
(431, 89, 'assets/images/places/edu/edu(1).jpg'),
(432, 89, 'assets/images/places/edu/edu(2).jpg'),
(433, 89, 'assets/images/places/edu/edu(3).jpg'),
(434, 89, 'assets/images/places/edu/edu(4).jpg'),
(435, 89, 'assets/images/places/edu/edu(5).jpg'),
(436, 90, 'assets/images/places/edu/edu(6).jpg'),
(437, 90, 'assets/images/places/edu/edu(7).jpg'),
(438, 90, 'assets/images/places/edu/edu(8).jpg'),
(439, 90, 'assets/images/places/edu/edu(9).jpg'),
(440, 90, 'assets/images/places/edu/edu(10).jpg'),
(441, 91, 'assets/images/places/edu/edu(11).jpg'),
(442, 91, 'assets/images/places/edu/edu(12).jpg'),
(443, 91, 'assets/images/places/edu/edu(13).jpg'),
(444, 91, 'assets/images/places/edu/edu(14).jpg'),
(445, 91, 'assets/images/places/edu/edu(15).jpg'),
(446, 92, 'assets/images/places/edu/edu(16).jpg'),
(447, 92, 'assets/images/places/edu/edu(17).jpg'),
(448, 92, 'assets/images/places/edu/edu(18).jpg'),
(449, 92, 'assets/images/places/edu/edu(19).jpg'),
(450, 92, 'assets/images/places/edu/edu(20).jpg'),
(451, 93, 'assets/images/places/edu/edu(21).jpg'),
(452, 93, 'assets/images/places/edu/edu(22).jpg'),
(453, 93, 'assets/images/places/edu/edu(23).jpg'),
(454, 93, 'assets/images/places/edu/edu(24).jpg'),
(455, 93, 'assets/images/places/edu/edu(25).jpg'),
(456, 94, 'assets/images/places/edu/edu(26).jpg'),
(457, 94, 'assets/images/places/edu/edu(27).jpg'),
(458, 94, 'assets/images/places/edu/edu(28).jpg'),
(459, 94, 'assets/images/places/edu/edu(29).jpg'),
(460, 94, 'assets/images/places/edu/edu(30).jpg'),
(461, 95, 'assets/images/places/edu/edu(31).jpg'),
(462, 95, 'assets/images/places/edu/edu(32).jpg'),
(463, 95, 'assets/images/places/edu/edu(33).jpg'),
(464, 95, 'assets/images/places/edu/edu(34).jpg'),
(465, 95, 'assets/images/places/edu/edu(35).jpg'),
(466, 96, 'assets/images/places/edu/edu(36).jpg'),
(467, 96, 'assets/images/places/edu/edu(37).jpg'),
(468, 96, 'assets/images/places/edu/edu(38).jpg'),
(469, 96, 'assets/images/places/edu/edu(39).jpg'),
(470, 96, 'assets/images/places/edu/edu(40).jpg'),
(471, 97, 'assets/images/places/edu/edu(41).jpg'),
(472, 97, 'assets/images/places/edu/edu(42).jpg'),
(473, 97, 'assets/images/places/edu/edu(43).jpg'),
(474, 97, 'assets/images/places/edu/edu(44).jpg'),
(475, 97, 'assets/images/places/edu/edu(45).jpg'),
(476, 98, 'assets/images/places/edu/edu(46).jpg'),
(477, 98, 'assets/images/places/edu/edu(47).jpg'),
(478, 98, 'assets/images/places/edu/edu(48).jpg'),
(479, 98, 'assets/images/places/edu/edu(49).jpg'),
(480, 98, 'assets/images/places/edu/edu(50).jpg'),
(481, 99, 'assets/images/places/edu/edu(51).jpg'),
(482, 99, 'assets/images/places/edu/edu(52).jpg'),
(483, 99, 'assets/images/places/edu/edu(53).jpg'),
(484, 99, 'assets/images/places/edu/edu(54).jpg'),
(485, 99, 'assets/images/places/edu/edu(55).jpg'),
(486, 100, 'assets/images/places/edu/edu(1).jpg'),
(487, 100, 'assets/images/places/edu/edu(2).jpg'),
(488, 100, 'assets/images/places/edu/edu(3).jpg'),
(489, 100, 'assets/images/places/edu/edu(4).jpg'),
(490, 100, 'assets/images/places/edu/edu(5).jpg'),
(491, 101, 'assets/images/places/edu/edu(6).jpg'),
(492, 101, 'assets/images/places/edu/edu(7).jpg'),
(493, 101, 'assets/images/places/edu/edu(8).jpg'),
(494, 101, 'assets/images/places/edu/edu(9).jpg'),
(495, 101, 'assets/images/places/edu/edu(10).jpg'),
(496, 102, 'assets/images/places/edu/edu(11).jpg'),
(497, 102, 'assets/images/places/edu/edu(12).jpg'),
(498, 102, 'assets/images/places/edu/edu(13).jpg'),
(499, 102, 'assets/images/places/edu/edu(14).jpg'),
(500, 102, 'assets/images/places/edu/edu(15).jpg'),
(501, 103, 'assets/images/places/edu/edu(16).jpg'),
(502, 103, 'assets/images/places/edu/edu(17).jpg'),
(503, 103, 'assets/images/places/edu/edu(18).jpg'),
(504, 103, 'assets/images/places/edu/edu(19).jpg'),
(505, 103, 'assets/images/places/edu/edu(20).jpg'),
(506, 104, 'assets/images/places/health/h(1).jpg'),
(507, 104, 'assets/images/places/health/h(2).jpg'),
(508, 104, 'assets/images/places/health/h(3).jpg'),
(509, 104, 'assets/images/places/health/h(4).jpg'),
(510, 104, 'assets/images/places/health/h(5).jpg'),
(511, 105, 'assets/images/places/health/h(6).jpg'),
(512, 105, 'assets/images/places/health/h(7).jpg'),
(513, 105, 'assets/images/places/health/h(8).jpg'),
(514, 105, 'assets/images/places/health/h(9).jpg'),
(515, 105, 'assets/images/places/health/h(10).jpg'),
(516, 106, 'assets/images/places/health/h(11).jpg'),
(517, 106, 'assets/images/places/health/h(12).jpg'),
(518, 106, 'assets/images/places/health/h(13).jpg'),
(519, 106, 'assets/images/places/health/h(14).jpg'),
(520, 106, 'assets/images/places/health/h(15).jpg'),
(521, 107, 'assets/images/places/health/h(16).jpg'),
(522, 107, 'assets/images/places/health/h(17).jpg'),
(523, 107, 'assets/images/places/health/h(18).jpg'),
(524, 107, 'assets/images/places/health/h(19).jpg'),
(525, 107, 'assets/images/places/health/h(20).jpg'),
(526, 108, 'assets/images/places/health/h(21).jpg'),
(527, 108, 'assets/images/places/health/h(22).jpg'),
(528, 108, 'assets/images/places/health/h(23).jpg'),
(529, 108, 'assets/images/places/health/h(24).jpg'),
(530, 108, 'assets/images/places/health/h(25).jpg'),
(531, 109, 'assets/images/places/health/h(26).jpg'),
(532, 109, 'assets/images/places/health/h(27).jpg'),
(533, 109, 'assets/images/places/health/h(28).jpg'),
(534, 109, 'assets/images/places/health/h(29).jpg'),
(535, 109, 'assets/images/places/health/h(30).jpg'),
(536, 110, 'assets/images/places/health/h(31).jpg'),
(537, 110, 'assets/images/places/health/h(32).jpg'),
(538, 110, 'assets/images/places/health/h(33).jpg'),
(539, 110, 'assets/images/places/health/h(34).jpg'),
(540, 110, 'assets/images/places/health/h(35).jpg'),
(541, 111, 'assets/images/places/health/h(36).jpg'),
(542, 111, 'assets/images/places/health/h(37).jpg'),
(543, 111, 'assets/images/places/health/h(1).jpg'),
(544, 111, 'assets/images/places/health/h(2).jpg'),
(545, 111, 'assets/images/places/health/h(3).jpg'),
(546, 112, 'assets/images/places/health/h(4).jpg'),
(547, 112, 'assets/images/places/health/h(5).jpg'),
(548, 112, 'assets/images/places/health/h(6).jpg'),
(549, 112, 'assets/images/places/health/h(7).jpg'),
(550, 112, 'assets/images/places/health/h(8).jpg'),
(551, 113, 'assets/images/places/health/h(9).jpg'),
(552, 113, 'assets/images/places/health/h(10).jpg'),
(553, 113, 'assets/images/places/health/h(11).jpg'),
(554, 113, 'assets/images/places/health/h(12).jpg'),
(555, 113, 'assets/images/places/health/h(13).jpg'),
(556, 114, 'assets/images/places/health/h(14).jpg'),
(557, 114, 'assets/images/places/health/h(15).jpg'),
(558, 114, 'assets/images/places/health/h(16).jpg'),
(559, 114, 'assets/images/places/health/h(17).jpg'),
(560, 114, 'assets/images/places/health/h(18).jpg'),
(561, 115, 'assets/images/places/health/h(19).jpg'),
(562, 115, 'assets/images/places/health/h(20).jpg'),
(563, 115, 'assets/images/places/health/h(21).jpg'),
(564, 115, 'assets/images/places/health/h(22).jpg'),
(565, 115, 'assets/images/places/health/h(23).jpg'),
(566, 116, 'assets/images/places/health/h(24).jpg'),
(567, 116, 'assets/images/places/health/h(25).jpg'),
(568, 116, 'assets/images/places/health/h(26).jpg'),
(569, 116, 'assets/images/places/health/h(27).jpg'),
(570, 116, 'assets/images/places/health/h(28).jpg'),
(571, 117, 'assets/images/places/health/h(29).jpg'),
(572, 117, 'assets/images/places/health/h(30).jpg'),
(573, 117, 'assets/images/places/health/h(31).jpg'),
(574, 117, 'assets/images/places/health/h(32).jpg'),
(575, 117, 'assets/images/places/health/h(33).jpg'),
(576, 104, 'assets/images/places/health/h(1).jpg'),
(577, 104, 'assets/images/places/health/h(2).jpg'),
(578, 104, 'assets/images/places/health/h(3).jpg'),
(579, 104, 'assets/images/places/health/h(4).jpg'),
(580, 104, 'assets/images/places/health/h(5).jpg'),
(581, 105, 'assets/images/places/health/h(6).jpg'),
(582, 105, 'assets/images/places/health/h(7).jpg'),
(583, 105, 'assets/images/places/health/h(8).jpg'),
(584, 105, 'assets/images/places/health/h(9).jpg'),
(585, 105, 'assets/images/places/health/h(10).jpg'),
(586, 106, 'assets/images/places/health/h(11).jpg'),
(587, 106, 'assets/images/places/health/h(12).jpg'),
(588, 106, 'assets/images/places/health/h(13).jpg'),
(589, 106, 'assets/images/places/health/h(14).jpg'),
(590, 106, 'assets/images/places/health/h(15).jpg'),
(591, 107, 'assets/images/places/health/h(16).jpg'),
(592, 107, 'assets/images/places/health/h(17).jpg'),
(593, 107, 'assets/images/places/health/h(18).jpg'),
(594, 107, 'assets/images/places/health/h(19).jpg'),
(595, 107, 'assets/images/places/health/h(20).jpg'),
(596, 108, 'assets/images/places/health/h(21).jpg'),
(597, 108, 'assets/images/places/health/h(22).jpg'),
(598, 108, 'assets/images/places/health/h(23).jpg'),
(599, 108, 'assets/images/places/health/h(24).jpg'),
(600, 108, 'assets/images/places/health/h(25).jpg'),
(601, 109, 'assets/images/places/health/h(26).jpg'),
(602, 109, 'assets/images/places/health/h(27).jpg'),
(603, 109, 'assets/images/places/health/h(28).jpg'),
(604, 109, 'assets/images/places/health/h(29).jpg'),
(605, 109, 'assets/images/places/health/h(30).jpg'),
(606, 110, 'assets/images/places/health/h(31).jpg'),
(607, 110, 'assets/images/places/health/h(32).jpg'),
(608, 110, 'assets/images/places/health/h(33).jpg'),
(609, 110, 'assets/images/places/health/h(34).jpg'),
(610, 110, 'assets/images/places/health/h(35).jpg'),
(611, 111, 'assets/images/places/health/h(36).jpg'),
(612, 111, 'assets/images/places/health/h(37).jpg'),
(613, 111, 'assets/images/places/health/h(1).jpg'),
(614, 111, 'assets/images/places/health/h(2).jpg'),
(615, 111, 'assets/images/places/health/h(3).jpg'),
(616, 112, 'assets/images/places/health/h(4).jpg'),
(617, 112, 'assets/images/places/health/h(5).jpg'),
(618, 112, 'assets/images/places/health/h(6).jpg'),
(619, 112, 'assets/images/places/health/h(7).jpg'),
(620, 112, 'assets/images/places/health/h(8).jpg'),
(621, 113, 'assets/images/places/health/h(9).jpg'),
(622, 113, 'assets/images/places/health/h(10).jpg'),
(623, 113, 'assets/images/places/health/h(11).jpg'),
(624, 113, 'assets/images/places/health/h(12).jpg'),
(625, 113, 'assets/images/places/health/h(13).jpg'),
(626, 114, 'assets/images/places/health/h(14).jpg'),
(627, 114, 'assets/images/places/health/h(15).jpg'),
(628, 114, 'assets/images/places/health/h(16).jpg'),
(629, 114, 'assets/images/places/health/h(17).jpg'),
(630, 114, 'assets/images/places/health/h(18).jpg'),
(631, 115, 'assets/images/places/health/h(19).jpg'),
(632, 115, 'assets/images/places/health/h(20).jpg'),
(633, 115, 'assets/images/places/health/h(21).jpg'),
(634, 115, 'assets/images/places/health/h(22).jpg'),
(635, 115, 'assets/images/places/health/h(23).jpg'),
(636, 116, 'assets/images/places/health/h(24).jpg'),
(637, 116, 'assets/images/places/health/h(25).jpg'),
(638, 116, 'assets/images/places/health/h(26).jpg'),
(639, 116, 'assets/images/places/health/h(27).jpg'),
(640, 116, 'assets/images/places/health/h(28).jpg'),
(641, 117, 'assets/images/places/health/h(29).jpg'),
(642, 117, 'assets/images/places/health/h(30).jpg'),
(643, 117, 'assets/images/places/health/h(31).jpg'),
(644, 117, 'assets/images/places/health/h(32).jpg'),
(645, 117, 'assets/images/places/health/h(33).jpg'),
(646, 118, 'assets/images/places/workspace/work(1).jpg'),
(647, 118, 'assets/images/places/workspace/work(2).jpg'),
(648, 118, 'assets/images/places/workspace/work(3).jpg'),
(649, 118, 'assets/images/places/workspace/work(4).jpg'),
(650, 118, 'assets/images/places/workspace/work(5).jpg'),
(651, 119, 'assets/images/places/workspace/work(6).jpg'),
(652, 119, 'assets/images/places/workspace/work(7).jpg'),
(653, 119, 'assets/images/places/workspace/work(8).jpg'),
(654, 119, 'assets/images/places/workspace/work(9).jpg'),
(655, 119, 'assets/images/places/workspace/work(10).jpg'),
(656, 120, 'assets/images/places/workspace/work(11).jpg'),
(657, 120, 'assets/images/places/workspace/work(12).jpg'),
(658, 120, 'assets/images/places/workspace/work(13).jpg'),
(659, 120, 'assets/images/places/workspace/work(14).jpg'),
(660, 120, 'assets/images/places/workspace/work(15).jpg'),
(661, 121, 'assets/images/places/workspace/work(16).jpg'),
(662, 121, 'assets/images/places/workspace/work(17).jpg'),
(663, 121, 'assets/images/places/workspace/work(18).jpg'),
(664, 121, 'assets/images/places/workspace/work(19).jpg'),
(665, 121, 'assets/images/places/workspace/work(20).jpg'),
(666, 122, 'assets/images/places/workspace/work(21).jpg'),
(667, 122, 'assets/images/places/workspace/work(22).jpg'),
(668, 122, 'assets/images/places/workspace/work(23).jpg'),
(669, 122, 'assets/images/places/workspace/work(24).jpg'),
(670, 122, 'assets/images/places/workspace/work(25).jpg'),
(671, 123, 'assets/images/places/workspace/work(26).jpg'),
(672, 123, 'assets/images/places/workspace/work(27).jpg'),
(673, 123, 'assets/images/places/workspace/work(28).jpg'),
(674, 123, 'assets/images/places/workspace/work(29).jpg'),
(675, 123, 'assets/images/places/workspace/work(30).jpg'),
(676, 124, 'assets/images/places/workspace/work(31).jpg'),
(677, 124, 'assets/images/places/workspace/work(32).jpg'),
(678, 124, 'assets/images/places/workspace/work(33).jpg'),
(679, 124, 'assets/images/places/workspace/work(34).jpg'),
(680, 124, 'assets/images/places/workspace/work(35).jpg'),
(681, 125, 'assets/images/places/workspace/work(36).jpg'),
(682, 125, 'assets/images/places/workspace/work(37).jpg'),
(683, 125, 'assets/images/places/workspace/work(38).jpg'),
(684, 125, 'assets/images/places/workspace/work(1).jpg'),
(685, 125, 'assets/images/places/workspace/work(2).jpg'),
(686, 126, 'assets/images/places/workspace/work(3).jpg'),
(687, 126, 'assets/images/places/workspace/work(4).jpg'),
(688, 126, 'assets/images/places/workspace/work(5).jpg'),
(689, 126, 'assets/images/places/workspace/work(6).jpg'),
(690, 126, 'assets/images/places/workspace/work(7).jpg'),
(691, 127, 'assets/images/places/workspace/work(8).jpg'),
(692, 127, 'assets/images/places/workspace/work(9).jpg'),
(693, 127, 'assets/images/places/workspace/work(10).jpg'),
(694, 127, 'assets/images/places/workspace/work(11).jpg'),
(695, 127, 'assets/images/places/workspace/work(12).jpg'),
(696, 128, 'assets/images/places/workspace/work(13).jpg'),
(697, 128, 'assets/images/places/workspace/work(14).jpg'),
(698, 128, 'assets/images/places/workspace/work(15).jpg'),
(699, 128, 'assets/images/places/workspace/work(16).jpg'),
(700, 128, 'assets/images/places/workspace/work(17).jpg'),
(701, 129, 'assets/images/places/workspace/work(18).jpg'),
(702, 129, 'assets/images/places/workspace/work(19).jpg'),
(703, 129, 'assets/images/places/workspace/work(20).jpg'),
(704, 129, 'assets/images/places/workspace/work(21).jpg'),
(705, 129, 'assets/images/places/workspace/work(22).jpg'),
(706, 130, 'assets/images/places/workspace/work(23).jpg'),
(707, 130, 'assets/images/places/workspace/work(24).jpg'),
(708, 130, 'assets/images/places/workspace/work(25).jpg'),
(709, 130, 'assets/images/places/workspace/work(26).jpg'),
(710, 130, 'assets/images/places/workspace/work(27).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `place_id`, `user_id`, `rating`, `review_text`, `created_at`) VALUES
(1, 1, 1, 5, 'Amazing food and great service! The flavors were rich, and the presentation was outstanding. The staff was very attentive, and the ambiance made for a perfect evening.', '2025-03-20 17:47:28'),
(2, 1, 2, 4, 'Really good experience, but a bit pricey. The dishes were well-prepared, and the ingredients seemed fresh. However, the portion sizes could have been slightly larger for the cost.', '2025-03-20 17:47:28'),
(3, 1, 3, 3, 'Food was decent but took too long. We had to wait over 40 minutes for our main course, which dampened the experience. The flavors were nice, but the wait time needs improvement.', '2025-03-20 17:47:28'),
(4, 2, 4, 5, 'Best restaurant I have visited! The flavors were exquisite, and every dish we ordered exceeded expectations. The desserts were particularly delightful, and I would highly recommend trying their signature dish.', '2025-03-20 17:47:28'),
(5, 2, 5, 4, 'Nice atmosphere and tasty dishes. The decor was stylish, and the background music added to the relaxing ambiance. The only downside was that it got a bit noisy as the evening progressed.', '2025-03-20 17:47:28'),
(6, 2, 6, 3, 'Average experience, nothing special. While the food was acceptable, there was nothing that truly stood out. The service was fine, but I expected more given the positive reviews.', '2025-03-20 17:47:28'),
(7, 3, 7, 5, 'Loved everything about this place! From the warm welcome at the entrance to the delicious food, everything was top-notch. The portion sizes were generous, and I will definitely be returning soon.', '2025-03-20 17:47:28'),
(8, 3, 8, 2, 'Service was slow and food was cold. Unfortunately, our meal was not served hot, and the waiting time was unreasonable. The staff seemed overwhelmed, and it affected the overall experience.', '2025-03-20 17:47:28'),
(9, 3, 9, 4, 'Great flavors and friendly staff. The seasoning of the dishes was spot on, and the staff went out of their way to ensure we had a good time. Will definitely be back!', '2025-03-20 17:47:28'),
(10, 4, 10, 5, 'Highly recommended! The food was fresh and flavorful, and the atmosphere was cozy yet elegant. Perfect for a date night or a special celebration.', '2025-03-20 17:47:28'),
(11, 4, 11, 3, 'Good but portions were small. While the taste was on point, I left feeling a bit hungry. The restaurant could consider slightly increasing portion sizes to match the price.', '2025-03-20 17:47:28'),
(12, 4, 12, 4, 'Nice selection of dishes and good ambiance. The menu had a variety of options, and the lighting and seating made for a comfortable dining experience. A solid choice for a nice evening out.', '2025-03-20 17:47:28'),
(13, 5, 13, 2, 'Overrated, didn’t enjoy it much. Perhaps my expectations were too high, but I found the food underwhelming. The service was also slow, and I probably won’t be coming back.', '2025-03-20 17:47:28'),
(14, 5, 14, 5, 'Perfect dining experience! The flavors, the service, and the presentation were all impeccable. The chef clearly knows what they’re doing, and I can’t wait to come back and try more dishes.', '2025-03-20 17:47:28'),
(15, 5, 15, 4, 'Will definitely come back. The food was delicious, and the staff was welcoming. A great place to enjoy a meal with family and friends.', '2025-03-20 17:47:28'),
(16, 6, 16, 3, 'Decent place but expected more. The food was fine, but there was nothing particularly exciting about it. Service was polite but a bit slow.', '2025-03-20 17:47:28'),
(17, 6, 17, 5, 'Absolutely fantastic! The meal was cooked to perfection, and every bite was flavorful. The staff was friendly and made sure we had a great experience.', '2025-03-20 17:47:28'),
(18, 6, 18, 4, 'Delicious and fresh ingredients. The quality of the ingredients used was evident in every bite. I also appreciated the variety of vegetarian options available.', '2025-03-20 17:47:28'),
(19, 7, 19, 2, 'Not worth the hype. I had high hopes for this place, but it did not live up to expectations. The food was bland, and the service was mediocre at best.', '2025-03-20 17:47:28'),
(20, 7, 20, 5, 'Exceptional service and food. Our server was incredibly friendly, and the food was absolutely delicious. The desserts were the perfect way to end the meal!', '2025-03-20 17:47:28'),
(21, 7, 21, 3, 'Had better experiences elsewhere. The restaurant wasn’t bad, but it wasn’t particularly memorable either. The food was okay, but nothing stood out.', '2025-03-20 17:47:28'),
(22, 8, 22, 4, 'Great value for the price. The portions were generous, and the flavors were well-balanced. I enjoyed my meal and would recommend it for a casual dining experience.', '2025-03-20 17:47:28'),
(23, 8, 23, 5, 'Would recommend to anyone! The food was incredible, and the ambiance was warm and welcoming. Definitely one of the best meals I’ve had in a long time.', '2025-03-20 17:47:28'),
(24, 8, 24, 3, 'Okay experience but nothing memorable. The restaurant was decent, but I wouldn’t go out of my way to visit again. The food was fine, but nothing stood out as particularly special.', '2025-03-20 17:47:28'),
(25, 9, 2, 5, 'A fantastic shopping experience! The mall had a great variety of stores, and I found everything I was looking for. The atmosphere was lively, and the food court had plenty of options.', '2025-03-20 17:52:32'),
(26, 9, 4, 4, 'Good selection of shops, but a bit crowded. It was tough to navigate during peak hours, but overall, I managed to find some great deals.', '2025-03-20 17:52:32'),
(27, 9, 6, 3, 'Decent mall, but parking was a nightmare. The stores were well-stocked, but getting in and out of the mall took longer than expected.', '2025-03-20 17:52:32'),
(28, 10, 8, 5, 'Amazing place to shop and hang out. The design of the mall was modern, and there were plenty of seating areas to rest between shopping.', '2025-03-20 17:52:32'),
(29, 10, 10, 4, 'Nice shopping experience but overpriced. Some stores were quite expensive, but I enjoyed browsing through the different brands.', '2025-03-20 17:52:32'),
(30, 10, 1, 3, 'Average experience, nothing special. It had the usual stores, but I didn’t find anything unique that stood out.', '2025-03-20 17:52:32'),
(31, 11, 5, 5, 'Loved the variety of stores! From high-end brands to budget-friendly options, this mall had it all. The layout was convenient, making it easy to explore.', '2025-03-20 17:52:32'),
(32, 11, 7, 2, 'Too crowded and noisy. I couldn’t really enjoy my shopping because of how packed it was. The checkout lines were way too long.', '2025-03-20 17:52:32'),
(33, 11, 12, 4, 'Good mall with great food options. I enjoyed trying different snacks and meals while shopping. The clothing stores had a nice selection too.', '2025-03-20 17:52:32'),
(34, 12, 14, 5, 'Highly recommended for shoppers! The stores had a wide variety of items, and the atmosphere was very pleasant. I loved the indoor decor and lighting.', '2025-03-20 17:52:32'),
(35, 12, 16, 3, 'Good but needs more seating areas. Shopping was fun, but I wish there were more places to sit and take a break.', '2025-03-20 17:52:32'),
(36, 12, 18, 4, 'Nice selection of brands and products. I found some great deals on clothes and electronics. A great mall overall!', '2025-03-20 17:52:32'),
(37, 13, 20, 2, 'Overrated, too expensive. Many stores were overpriced, and I didn’t find many good discounts.', '2025-03-20 17:52:32'),
(38, 13, 22, 5, 'Perfect shopping destination! Everything was well-organized, and the staff in most stores were very helpful. Will definitely return!', '2025-03-20 17:52:32'),
(39, 13, 24, 4, 'Will definitely come back. A good mix of stores and a relaxing atmosphere made for an enjoyable shopping experience.', '2025-03-20 17:52:32'),
(40, 14, 26, 3, 'Decent place but expected more. The mall was okay, but I’ve seen better ones with more variety.', '2025-03-20 17:52:32'),
(41, 14, 15, 5, 'Absolutely fantastic! From shopping to dining, this place had it all. I spent hours here and still felt like I needed more time!', '2025-03-20 17:52:32'),
(42, 14, 17, 4, 'Lots of options for shopping and dining. The food court had some delicious choices, and I managed to find great deals on clothes.', '2025-03-20 17:52:32'),
(43, 15, 19, 2, 'Not worth the trip. I didn’t find anything interesting, and the prices were quite high compared to other malls.', '2025-03-20 17:52:32'),
(44, 15, 30, 5, 'Exceptional shopping experience! The store variety, cleanliness, and customer service made it a pleasant visit.', '2025-03-20 17:52:32'),
(45, 15, 33, 3, 'Had better experiences elsewhere. It was just an average mall with nothing particularly exciting.', '2025-03-20 17:52:32'),
(46, 16, 32, 4, 'Great value for shopping. Found some amazing discounts, and the mall was easy to navigate.', '2025-03-20 17:52:32'),
(47, 16, 29, 5, 'Would recommend to anyone! The shopping options, entertainment areas, and food choices made this a great experience.', '2025-03-20 17:52:32'),
(48, 16, 9, 3, 'Okay experience but nothing memorable. The stores were fine, but I wouldn’t go out of my way to visit again.', '2025-03-20 17:52:32'),
(49, 17, 25, 5, 'An incredible experience! The facilities were top-notch, and the staff was very friendly. Perfect place to stay active and enjoy the outdoors.', '2025-03-20 17:55:47'),
(50, 17, 26, 4, 'Great spot for outdoor activities. The walking trails were well-maintained, and the atmosphere was peaceful. Would love to visit again!', '2025-03-20 17:55:47'),
(51, 17, 27, 3, 'Decent experience, but could use better maintenance. Some areas felt a bit neglected, but overall, it was a good place for exercise.', '2025-03-20 17:55:47'),
(52, 18, 28, 5, 'Fantastic place for an active lifestyle! The variety of activities available made it a fun and engaging experience. Highly recommended!', '2025-03-20 17:55:47'),
(53, 18, 29, 4, 'Enjoyable visit, but a bit crowded. It was hard to fully relax and enjoy due to the number of people, but the activities were great.', '2025-03-20 17:55:47'),
(54, 18, 30, 3, 'Not bad, but expected more. The equipment was fine, but some areas needed repairs. Decent for a casual visit.', '2025-03-20 17:55:47'),
(55, 19, 31, 5, 'Absolutely loved it! The environment was perfect for staying active, and I had a great time with friends. Will definitely return!', '2025-03-20 17:55:47'),
(56, 19, 32, 2, 'Too busy and noisy. It was hard to focus on any activity because of the crowd. Would recommend going at a quieter time.', '2025-03-20 17:55:47'),
(57, 19, 33, 4, 'Good place for fitness enthusiasts. The outdoor spaces were great for workouts, and the overall atmosphere was motivating.', '2025-03-20 17:55:47'),
(58, 20, 1, 5, 'A must-visit for those who love an active lifestyle! The trails, sports facilities, and atmosphere made it a fantastic experience.', '2025-03-20 17:55:47'),
(59, 20, 2, 3, 'Average at best. It was okay, but I’ve been to better places with more options for activities.', '2025-03-20 17:55:47'),
(60, 20, 3, 4, 'Really enjoyed the day here! The variety of activities kept me engaged, and the staff was very helpful.', '2025-03-20 17:55:47'),
(61, 21, 4, 2, 'Not what I expected. The facilities were not well-maintained, and the pricing seemed a bit high for what was offered.', '2025-03-20 17:55:47'),
(62, 21, 5, 5, 'Had an amazing time! The perfect place to get some exercise and unwind. Would highly recommend it to anyone looking for an active getaway.', '2025-03-20 17:55:47'),
(63, 21, 6, 4, 'Well-organized and fun. There were plenty of options for activities, and I had a great time trying them all.', '2025-03-20 17:55:47'),
(64, 22, 7, 3, 'Decent experience but not outstanding. It was a good place to be active, but I felt like some areas could have been improved.', '2025-03-20 17:55:47'),
(65, 22, 8, 5, 'Loved every moment here! The outdoor setup was amazing, and I had a great time engaging in different activities. Can’t wait to return!', '2025-03-20 17:55:47'),
(66, 22, 9, 4, 'Great place for a workout. The facilities were well-kept, and I enjoyed trying out different activities throughout the day.', '2025-03-20 17:55:47'),
(67, 23, 10, 5, 'Excellent service! The team was professional, efficient, and ensured every detail was perfect. Highly recommended!', '2025-03-20 17:57:48'),
(68, 23, 11, 4, 'Great experience overall. The service was good, but the response time could have been better. Would still use them again!', '2025-03-20 17:57:48'),
(69, 23, 12, 3, 'Average service. The job was done, but I expected a bit more attention to detail.', '2025-03-20 17:57:48'),
(70, 24, 13, 5, 'Fantastic home service! The workers were friendly and skilled. My house looks amazing now!', '2025-03-20 17:57:48'),
(71, 24, 14, 4, 'Pretty good service. The pricing was reasonable, and the work was done on time. I am happy with the results.', '2025-03-20 17:57:48'),
(72, 24, 15, 3, 'Decent experience, but there was a slight delay in the process. Not bad, but could be better.', '2025-03-20 17:57:48'),
(73, 25, 16, 5, 'Absolutely top-notch! The professionals handled everything efficiently, and my home has never looked better!', '2025-03-20 17:57:48'),
(74, 25, 17, 2, 'Not the best experience. There were issues with scheduling, and the work wasn’t up to my expectations.', '2025-03-20 17:57:48'),
(75, 25, 18, 4, 'Great service! The staff was polite, and they did a great job fixing my home issues.', '2025-03-20 17:57:48'),
(76, 26, 19, 5, 'Outstanding service! They went above and beyond to make sure everything was perfect. Highly recommend!', '2025-03-20 17:57:48'),
(77, 26, 20, 3, 'It was okay, but I felt like the quality of work could have been better for the price I paid.', '2025-03-20 17:57:48'),
(78, 26, 21, 4, 'Very reliable and efficient. They took care of everything as promised and were very professional.', '2025-03-20 17:57:48'),
(79, 27, 22, 2, 'Not what I expected. The service was slow, and the quality of work was subpar.', '2025-03-20 17:57:48'),
(80, 27, 23, 5, 'Perfect experience! The workers were knowledgeable and did a fantastic job. I would definitely hire them again.', '2025-03-20 17:57:48'),
(81, 27, 24, 4, 'Pretty good home service, but they arrived a bit later than expected. Otherwise, everything was fine.', '2025-03-20 17:57:48'),
(82, 28, 25, 3, 'A decent service overall. Nothing too impressive, but it got the job done.', '2025-03-20 17:57:48'),
(83, 28, 26, 5, 'Amazing job! My home has never looked better. The team was punctual and professional!', '2025-03-20 17:57:48'),
(84, 28, 27, 4, 'Very happy with the results. The process was smooth, and they completed the work quickly.', '2025-03-20 17:57:48'),
(85, 29, 28, 5, 'Incredible service! The workers were friendly, professional, and completed everything perfectly.', '2025-03-20 17:57:48'),
(86, 29, 29, 3, 'An okay experience. The work was satisfactory, but the price was a little high for what I got.', '2025-03-20 17:57:48'),
(87, 29, 30, 4, 'A great company with solid service. Would recommend for home maintenance needs.', '2025-03-20 17:57:48'),
(88, 30, 31, 5, 'Couldn’t have asked for better service! They were prompt, efficient, and very skilled.', '2025-03-20 17:57:48'),
(89, 30, 32, 2, 'Not the best service. They didn’t meet my expectations and took too long to finish the job.', '2025-03-20 17:57:48'),
(90, 30, 33, 4, 'Very reliable service. The quality of work was excellent, but there were slight delays.', '2025-03-20 17:57:48'),
(91, 31, 1, 5, 'Outstanding work! The team really knew what they were doing, and the results speak for themselves!', '2025-03-20 17:57:48'),
(92, 31, 2, 3, 'The service was okay, but I expected more for the price. It wasn’t bad, but it wasn’t great either.', '2025-03-20 17:57:48'),
(93, 31, 3, 4, 'A solid home service experience. The workers were friendly and knew their job well.', '2025-03-20 17:57:48'),
(94, 32, 4, 2, 'Not satisfied with the service. There were too many issues with communication and quality.', '2025-03-20 17:57:48'),
(95, 32, 5, 5, 'Loved it! The service was smooth, and the results were exactly what I wanted. Great job!', '2025-03-20 17:57:48'),
(96, 32, 6, 4, 'Reliable and professional. They handled everything well, and I was happy with the outcome.', '2025-03-20 17:57:48'),
(97, 33, 7, 3, 'Decent service, but not outstanding. The work was done properly, but the price was a bit high.', '2025-03-20 17:57:48'),
(98, 33, 8, 5, 'Fantastic job! They were efficient and left my home looking great!', '2025-03-20 17:57:48'),
(99, 33, 9, 4, 'Good quality work. The only downside was that they took a bit longer than expected.', '2025-03-20 17:57:48'),
(100, 34, 10, 5, 'Couldn’t have asked for better service! Everything was handled smoothly and efficiently.', '2025-03-20 17:57:48'),
(101, 34, 11, 3, 'It was fine, but nothing extraordinary. The work was done, but it took a little longer than expected.', '2025-03-20 17:57:48'),
(102, 34, 12, 4, 'Pretty good experience. The workers were professional and got the job done well.', '2025-03-20 17:57:48'),
(103, 35, 13, 5, 'This coffee shop is my new favorite spot! The atmosphere is cozy, and the coffee is always fresh and flavorful.', '2025-03-20 18:00:14'),
(104, 35, 14, 4, 'Good coffee and a nice ambiance. The only downside is that it can get a bit crowded during peak hours.', '2025-03-20 18:00:14'),
(105, 35, 15, 3, 'Decent coffee, but the service was a bit slow. I might give it another try on a less busy day.', '2025-03-20 18:00:14'),
(106, 36, 16, 5, 'Amazing place for coffee lovers! The baristas are skilled, and the espresso is just perfect!', '2025-03-20 18:00:14'),
(107, 36, 17, 4, 'Really nice selection of drinks. The pastries are also fresh and delicious.', '2025-03-20 18:00:14'),
(108, 36, 18, 3, 'Not bad, but I found the coffee a bit too bitter for my taste. The seating area is comfortable though.', '2025-03-20 18:00:14'),
(109, 37, 19, 5, 'Best cappuccino I’ve had in a long time! This place knows how to make great coffee.', '2025-03-20 18:00:14'),
(110, 37, 20, 2, 'The coffee was overpriced, and the staff seemed uninterested. Not a great experience.', '2025-03-20 18:00:14'),
(111, 37, 21, 4, 'Lovely little cafe with great service. A good place to relax with a book and a latte.', '2025-03-20 18:00:14'),
(112, 38, 22, 5, 'Fantastic coffee shop! The cold brew is strong and refreshing, and the staff is very friendly.', '2025-03-20 18:00:14'),
(113, 38, 23, 3, 'The coffee was okay, but I expected more given the hype around this place.', '2025-03-20 18:00:14'),
(114, 38, 24, 4, 'Nice atmosphere and friendly staff. The coffee is pretty good too!', '2025-03-20 18:00:14'),
(115, 39, 25, 2, 'Did not enjoy my visit here. The coffee was weak, and the service was slow.', '2025-03-20 18:00:14'),
(116, 39, 26, 5, 'Absolutely loved the experience! The caramel macchiato was rich and flavorful.', '2025-03-20 18:00:14'),
(117, 39, 27, 4, 'Good coffee and friendly staff. The outdoor seating area is a great bonus!', '2025-03-20 18:00:14'),
(118, 40, 28, 3, 'Average coffee, but the location is convenient. Might visit again.', '2025-03-20 18:00:14'),
(119, 40, 29, 5, 'Excellent coffee shop! The espresso is strong, and the desserts are delicious!', '2025-03-20 18:00:14'),
(120, 40, 30, 4, 'A solid coffee place. The ambiance is nice, and the drinks are well-made.', '2025-03-20 18:00:14'),
(121, 41, 31, 5, 'Absolutely fantastic! Great coffee, amazing service, and a relaxing atmosphere.', '2025-03-20 18:00:14'),
(122, 41, 32, 2, 'Not worth the hype. The coffee was overpriced, and I didn’t find it special.', '2025-03-20 18:00:14'),
(123, 41, 33, 4, 'Enjoyed my visit here. The coffee was good, and the staff was friendly.', '2025-03-20 18:00:14'),
(124, 42, 1, 5, 'Perfect spot for coffee lovers! The baristas are knowledgeable, and the coffee is exceptional.', '2025-03-20 18:00:14'),
(125, 42, 2, 3, 'An okay coffee shop. The drinks were fine, but nothing stood out.', '2025-03-20 18:00:14'),
(126, 42, 3, 4, 'A great place to catch up with friends over a cup of coffee. Comfortable seating and good service.', '2025-03-20 18:00:14'),
(127, 43, 4, 2, 'I was disappointed. The coffee was too watered down, and the staff was not welcoming.', '2025-03-20 18:00:14'),
(128, 43, 5, 5, 'Loved this place! The lattes are amazing, and they have a great selection of pastries.', '2025-03-20 18:00:14'),
(129, 43, 6, 4, 'A nice spot with good coffee. The decor is also really cozy and inviting.', '2025-03-20 18:00:14'),
(130, 44, 7, 3, 'The coffee was average, but the location is nice. I might give it another chance.', '2025-03-20 18:00:14'),
(131, 44, 8, 5, 'Excellent experience! The pour-over coffee was smooth and flavorful.', '2025-03-20 18:00:14'),
(132, 44, 9, 4, 'Great little coffee shop with friendly staff and quality drinks.', '2025-03-20 18:00:14'),
(133, 45, 10, 5, 'This place is a hidden gem! The coffee is fantastic, and the ambiance is just right.', '2025-03-20 18:00:14'),
(134, 45, 11, 3, 'It was fine, but I expected better coffee based on the reviews.', '2025-03-20 18:00:14'),
(135, 45, 12, 4, 'Enjoyed my coffee here. The service was friendly, and the drinks were well made.', '2025-03-20 18:00:14'),
(136, 46, 13, 5, 'Top-notch coffee! The staff is passionate about what they do, and it shows in every cup.', '2025-03-20 18:00:14'),
(137, 46, 14, 3, 'The drinks were okay, but the seating area was too cramped for my liking.', '2025-03-20 18:00:14'),
(138, 46, 15, 4, 'Good coffee and a nice selection of snacks. Would visit again!', '2025-03-20 18:00:14'),
(139, 47, 16, 2, 'Did not have a great experience. The coffee was cold, and the service was slow.', '2025-03-20 18:00:14'),
(140, 47, 17, 5, 'One of the best coffee shops I’ve been to! The atmosphere is great, and the drinks are top quality.', '2025-03-20 18:00:14'),
(141, 47, 18, 4, 'Solid coffee place with good service. A great spot to relax and unwind.', '2025-03-20 18:00:14'),
(142, 48, 19, 3, 'Decent coffee, but I felt like it was missing something special.', '2025-03-20 18:00:14'),
(143, 48, 20, 5, 'Absolutely amazing! The best espresso I’ve had in a long time.', '2025-03-20 18:00:14'),
(144, 48, 21, 4, 'Nice coffee shop with friendly baristas. The drinks are well-crafted and delicious.', '2025-03-20 18:00:14'),
(145, 49, 22, 5, 'A must-visit for coffee lovers! The beans are freshly roasted, and the drinks are always excellent.', '2025-03-20 18:00:14'),
(146, 49, 23, 3, 'An okay coffee shop. Nothing spectacular, but it does the job.', '2025-03-20 18:00:14'),
(147, 49, 24, 4, 'Great coffee and friendly service. I’ll be coming back for sure!', '2025-03-20 18:00:14'),
(148, 50, 25, 5, 'This pet store is amazing! They have everything my pet needs, and the staff is very helpful.', '2025-03-20 18:02:27'),
(149, 50, 26, 4, 'A great selection of pet food and accessories. Prices are reasonable too.', '2025-03-20 18:02:27'),
(150, 50, 27, 3, 'Decent store, but they could improve their customer service a bit.', '2025-03-20 18:02:27'),
(151, 51, 28, 5, 'Fantastic pet shop! My dog loves the treats from here.', '2025-03-20 18:02:27'),
(152, 51, 29, 4, 'Good variety of pet supplies, and the staff is very knowledgeable.', '2025-03-20 18:02:27'),
(153, 51, 30, 3, 'An okay store, but they were out of stock on a few items I needed.', '2025-03-20 18:02:27'),
(154, 52, 31, 5, 'This place has the best selection of pet toys and food. Highly recommend!', '2025-03-20 18:02:27'),
(155, 52, 32, 2, 'I wasn’t impressed. The staff seemed uninterested, and the prices were high.', '2025-03-20 18:02:27'),
(156, 52, 33, 4, 'Nice pet store with a good selection. Prices are fair too!', '2025-03-20 18:02:27'),
(157, 53, 1, 5, 'Great pet shop! They have everything I need for my cat.', '2025-03-20 18:02:27'),
(158, 53, 2, 3, 'Not bad, but I wish they had more variety for smaller pets.', '2025-03-20 18:02:27'),
(159, 53, 3, 4, 'Helpful staff and good quality products. Will visit again.', '2025-03-20 18:02:27'),
(160, 54, 4, 2, 'Disappointed with the lack of stock. Could use more organization.', '2025-03-20 18:02:27'),
(161, 54, 5, 5, 'Excellent selection and friendly staff! My pet loves the new food I got here.', '2025-03-20 18:02:27'),
(162, 54, 6, 4, 'A good pet store with reasonable prices and a nice selection.', '2025-03-20 18:02:27'),
(163, 55, 7, 3, 'Average pet store. Nothing too special, but they had what I needed.', '2025-03-20 18:02:27'),
(164, 55, 8, 5, 'Great customer service! The staff helped me choose the best food for my dog.', '2025-03-20 18:02:27'),
(165, 55, 9, 4, 'A nice place to shop for pet supplies. I found everything I needed.', '2025-03-20 18:02:27'),
(166, 56, 10, 5, 'One of the best pet stores in town! Great products and friendly service.', '2025-03-20 18:02:27'),
(167, 56, 11, 3, 'It was okay, but I felt like they could expand their selection a bit.', '2025-03-20 18:02:27'),
(168, 56, 12, 4, 'A good place to find quality pet products at fair prices.', '2025-03-20 18:02:27'),
(169, 57, 13, 5, 'Amazing pet store! The staff truly cares about animals and their customers.', '2025-03-20 18:02:27'),
(170, 57, 14, 3, 'The store was clean and well-organized, but prices were a bit high.', '2025-03-20 18:02:27'),
(171, 57, 15, 4, 'I had a good shopping experience. The staff was friendly and helpful.', '2025-03-20 18:02:27'),
(172, 58, 1, 5, 'This plant shop has a wonderful variety of plants and the staff is very helpful!', '2025-03-20 18:05:08'),
(173, 58, 2, 4, 'Great selection of indoor plants, but they could improve their outdoor plant range.', '2025-03-20 18:05:08'),
(174, 58, 3, 3, 'Decent shop, but the prices are a bit high for the variety they offer.', '2025-03-20 18:05:08'),
(175, 59, 4, 5, 'I love this plant shop! They have the best collection of succulents and cacti.', '2025-03-20 18:05:08'),
(176, 59, 5, 4, 'Good variety of plants and friendly staff. Would like to see more rare plants though.', '2025-03-20 18:05:08'),
(177, 59, 6, 3, 'Nice shop, but I found the same plants cheaper elsewhere.', '2025-03-20 18:05:08'),
(178, 60, 7, 5, 'This is my go-to shop for plants. They have everything I need for my garden!', '2025-03-20 18:05:08'),
(179, 60, 8, 2, 'I was disappointed with the selection. Not many plants to choose from and the prices were too high.', '2025-03-20 18:05:08'),
(180, 60, 9, 4, 'Good shop with a great range of plants. A bit on the expensive side, but quality is good.', '2025-03-20 18:05:08'),
(181, 61, 10, 5, 'Amazing store! The plants are healthy, and the staff gave me great advice on care.', '2025-03-20 18:05:08'),
(182, 61, 11, 3, 'Okay shop, but I expected more variety for larger plants.', '2025-03-20 18:05:08'),
(183, 61, 12, 4, 'Good selection, helpful staff, but the prices could be more reasonable.', '2025-03-20 18:05:08'),
(184, 62, 13, 5, 'Best plant shop I’ve been to! They have everything from rare orchids to garden plants.', '2025-03-20 18:05:08'),
(185, 62, 14, 3, 'Nice variety, but the plants seemed overpriced for their size.', '2025-03-20 18:05:08'),
(186, 62, 15, 4, 'Great quality plants, but I wish they had more options for indoor plants.', '2025-03-20 18:05:08'),
(187, 63, 16, 2, 'Not a fan. The plants looked unhealthy and there were not many options.', '2025-03-20 18:05:08'),
(188, 63, 17, 5, 'Excellent plant store! The staff helped me pick the perfect plants for my home.', '2025-03-20 18:05:08'),
(189, 63, 18, 4, 'Decent selection, but I felt like the store could have been more organized.', '2025-03-20 18:05:08'),
(190, 64, 19, 3, 'This store has good plants, but they didn’t have the one I was looking for.', '2025-03-20 18:05:08'),
(191, 64, 20, 5, 'Great place for rare plants! They had exactly what I needed for my collection.', '2025-03-20 18:05:08'),
(192, 64, 21, 4, 'Good variety of plants, though the store could use a bit of improvement in presentation.', '2025-03-20 18:05:08'),
(193, 65, 22, 5, 'Love this place! Best collection of tropical plants in the city.', '2025-03-20 18:05:08'),
(194, 65, 23, 3, 'The store is okay, but I wish they had more space for larger plants.', '2025-03-20 18:05:08'),
(195, 65, 24, 4, 'Great selection of plants! Helpful staff, but could use a few more specialty items.', '2025-03-20 18:05:08'),
(196, 65, 25, 5, 'The best plant shop! I always find the most beautiful and healthy plants here.', '2025-03-20 18:05:08'),
(197, 74, 1, 5, 'The hotel was fantastic. The service was impeccable, the room was comfortable, and the location was perfect for exploring the area. I couldn’t have asked for a better stay.', '2025-03-20 18:14:10'),
(198, 75, 2, 4, 'A great stay overall! The hotel staff were friendly and the amenities were top-notch. The breakfast buffet was also a standout. Would love to come back again.', '2025-03-20 18:14:10'),
(199, 76, 3, 3, 'Nice hotel, but it felt a little dated. The room was clean and the staff were friendly, but I think the hotel could use a bit of modernization.', '2025-03-20 18:14:10'),
(200, 77, 4, 5, 'Absolutely loved the hotel. The design was beautiful, the views were amazing, and the staff were so accommodating. I can’t recommend this place enough.', '2025-03-20 18:14:10'),
(201, 78, 5, 4, 'Had a great experience at this hotel. The rooms were spacious and clean, and the staff were professional and helpful. The only downside was the noise from outside.', '2025-03-20 18:14:10'),
(202, 79, 6, 3, 'Good hotel but nothing extraordinary. The room was comfortable, but I expected more in terms of amenities and the overall experience.', '2025-03-20 18:14:10'),
(203, 80, 7, 5, 'Perfect stay! The service was beyond amazing, and the hotel offered everything I needed and more. A great location and a beautiful property.', '2025-03-20 18:14:10'),
(204, 81, 8, 4, 'The hotel was lovely, though I had a minor issue with my room’s air conditioning. The staff fixed it quickly, though, and the overall experience was still fantastic.', '2025-03-20 18:14:10'),
(205, 82, 9, 5, 'I had an incredible experience here. The hotel’s design and ambiance were perfect. The staff was friendly and went out of their way to make sure I felt comfortable.', '2025-03-20 18:14:10'),
(206, 83, 10, 4, 'I had a good experience at this hotel. The location was great, and the amenities were more than sufficient. However, I felt the staff could have been more attentive.', '2025-03-20 18:14:10'),
(207, 84, 11, 3, 'Decent hotel but not the best. The room was okay, though not as luxurious as expected. The hotel’s location was convenient, but I would have liked a better view.', '2025-03-20 18:14:10'),
(208, 85, 12, 5, 'This hotel exceeded my expectations. From the modern decor to the incredible views, everything was perfect. I would definitely stay here again.', '2025-03-20 18:14:10'),
(209, 86, 13, 4, 'I enjoyed my stay, but the breakfast options could have been better. Otherwise, the hotel was lovely and the staff was very accommodating.', '2025-03-20 18:14:10'),
(210, 87, 14, 5, 'What an amazing experience! The hotel was spotless, the food was delicious, and the staff was incredibly friendly. The view from my room was breathtaking.', '2025-03-20 18:14:10'),
(211, 88, 15, 4, 'A very pleasant stay. The room was clean and comfortable, but the hotel could improve in terms of offering more activities and experiences. Would recommend for a quick getaway.', '2025-03-20 18:14:10'),
(212, 74, 1, 5, 'The hotel was fantastic. The service was impeccable, the room was comfortable, and the location was perfect for exploring the area. I couldn’t have asked for a better stay.', '2025-03-20 18:14:46'),
(213, 75, 2, 4, 'A great stay overall! The hotel staff were friendly and the amenities were top-notch. The breakfast buffet was also a standout. Would love to come back again.', '2025-03-20 18:14:46'),
(214, 76, 3, 3, 'Nice hotel, but it felt a little dated. The room was clean and the staff were friendly, but I think the hotel could use a bit of modernization.', '2025-03-20 18:14:46'),
(215, 77, 4, 5, 'Absolutely loved the hotel. The design was beautiful, the views were amazing, and the staff were so accommodating. I can’t recommend this place enough.', '2025-03-20 18:14:46'),
(216, 78, 5, 4, 'Had a great experience at this hotel. The rooms were spacious and clean, and the staff were professional and helpful. The only downside was the noise from outside.', '2025-03-20 18:14:46'),
(217, 79, 6, 3, 'Good hotel but nothing extraordinary. The room was comfortable, but I expected more in terms of amenities and the overall experience.', '2025-03-20 18:14:46'),
(218, 80, 7, 5, 'Perfect stay! The service was beyond amazing, and the hotel offered everything I needed and more. A great location and a beautiful property.', '2025-03-20 18:14:46'),
(219, 81, 8, 4, 'The hotel was lovely, though I had a minor issue with my room’s air conditioning. The staff fixed it quickly, though, and the overall experience was still fantastic.', '2025-03-20 18:14:46'),
(220, 82, 9, 5, 'I had an incredible experience here. The hotel’s design and ambiance were perfect. The staff was friendly and went out of their way to make sure I felt comfortable.', '2025-03-20 18:14:46'),
(221, 83, 10, 4, 'I had a good experience at this hotel. The location was great, and the amenities were more than sufficient. However, I felt the staff could have been more attentive.', '2025-03-20 18:14:46'),
(222, 84, 11, 3, 'Decent hotel but not the best. The room was okay, though not as luxurious as expected. The hotel’s location was convenient, but I would have liked a better view.', '2025-03-20 18:14:46'),
(223, 85, 12, 5, 'This hotel exceeded my expectations. From the modern decor to the incredible views, everything was perfect. I would definitely stay here again.', '2025-03-20 18:14:46'),
(224, 86, 13, 4, 'I enjoyed my stay, but the breakfast options could have been better. Otherwise, the hotel was lovely and the staff was very accommodating.', '2025-03-20 18:14:46'),
(225, 87, 14, 5, 'What an amazing experience! The hotel was spotless, the food was delicious, and the staff was incredibly friendly. The view from my room was breathtaking.', '2025-03-20 18:14:46'),
(226, 88, 15, 4, 'A very pleasant stay. The room was clean and comfortable, but the hotel could improve in terms of offering more activities and experiences. Would recommend for a quick getaway.', '2025-03-20 18:14:46'),
(227, 74, 1, 5, 'The hotel was fantastic. The service was impeccable, the room was comfortable, and the location was perfect for exploring the area. I couldn’t have asked for a better stay.', '2025-03-20 18:18:17'),
(228, 74, 2, 4, 'A great stay overall! The hotel staff were friendly and the amenities were top-notch. The breakfast buffet was also a standout. Would love to come back again.', '2025-03-20 18:18:17'),
(229, 74, 3, 3, 'Nice hotel, but it felt a little dated. The room was clean and the staff were friendly, but I think the hotel could use a bit of modernization.', '2025-03-20 18:18:17'),
(230, 75, 4, 5, 'Absolutely loved the hotel. The design was beautiful, the views were amazing, and the staff were so accommodating. I can’t recommend this place enough.', '2025-03-20 18:18:17'),
(231, 75, 5, 4, 'Had a great experience at this hotel. The rooms were spacious and clean, and the staff were professional and helpful. The only downside was the noise from outside.', '2025-03-20 18:18:17'),
(232, 75, 6, 3, 'Good hotel but nothing extraordinary. The room was comfortable, but I expected more in terms of amenities and the overall experience.', '2025-03-20 18:18:17'),
(233, 76, 7, 5, 'Perfect stay! The service was beyond amazing, and the hotel offered everything I needed and more. A great location and a beautiful property.', '2025-03-20 18:18:17'),
(234, 76, 8, 4, 'The hotel was lovely, though I had a minor issue with my room’s air conditioning. The staff fixed it quickly, though, and the overall experience was still fantastic.', '2025-03-20 18:18:17'),
(235, 76, 9, 5, 'I had an incredible experience here. The hotel’s design and ambiance were perfect. The staff was friendly and went out of their way to make sure I felt comfortable.', '2025-03-20 18:18:17'),
(236, 77, 10, 4, 'I had a good experience at this hotel. The location was great, and the amenities were more than sufficient. However, I felt the staff could have been more attentive.', '2025-03-20 18:18:17'),
(237, 77, 11, 5, 'This hotel exceeded my expectations. From the modern decor to the incredible views, everything was perfect. I would definitely stay here again.', '2025-03-20 18:18:17'),
(238, 77, 12, 3, 'Decent hotel but not the best. The room was okay, though not as luxurious as expected. The hotel’s location was convenient, but I would have liked a better view.', '2025-03-20 18:18:17'),
(239, 78, 13, 5, 'I had an incredible experience here. The service was exceptional, and the room was very comfortable. The hotel was also in a great location.', '2025-03-20 18:18:17'),
(240, 78, 14, 4, 'The stay was great! The room was clean and the staff was polite. The only downside was that I felt the hotel was a little too noisy at night.', '2025-03-20 18:18:17'),
(241, 78, 15, 4, 'A pleasant stay overall. The hotel was comfortable, but the amenities could be a little better. Still, a great experience.', '2025-03-20 18:18:17'),
(242, 79, 16, 3, 'Good hotel, but there was a slight issue with the cleanliness of my room. The staff were friendly, but the hotel itself needs a little maintenance.', '2025-03-20 18:18:17'),
(243, 79, 17, 5, 'Absolutely perfect! The hotel was very clean, and the service was excellent. I loved my stay and will definitely return.', '2025-03-20 18:18:17'),
(244, 79, 18, 4, 'The hotel is quite good. The staff were friendly and helpful. The amenities were also good, but I feel like it could be slightly better for the price.', '2025-03-20 18:18:17'),
(245, 80, 19, 5, 'Perfect place to stay for a short trip. The rooms were spacious, and the staff made sure we had everything we needed. I would highly recommend it.', '2025-03-20 18:18:17'),
(246, 80, 20, 4, 'Nice hotel, though the room was a bit smaller than expected. Still, everything else, including the location, was great.', '2025-03-20 18:18:17'),
(247, 80, 21, 4, 'Had a lovely stay here. The staff was very friendly, and the hotel’s location was ideal. Just wish the Wi-Fi was faster.', '2025-03-20 18:18:17'),
(248, 81, 22, 5, 'I loved this place! The staff were amazing, and the room was perfect. The hotel was well-maintained and had great amenities.', '2025-03-20 18:18:17'),
(249, 81, 23, 5, 'What an amazing experience! The hotel was pristine, and the staff were always available for any requests. I’ll be back for sure.', '2025-03-20 18:18:17'),
(250, 81, 24, 3, 'The hotel was decent, but there was a bit of a mix-up with our booking. The staff resolved it, but the delay was a bit frustrating.', '2025-03-20 18:18:17'),
(251, 82, 25, 5, 'Incredible experience! The hotel was stylish, comfortable, and the location was perfect for exploring the city. Highly recommend!', '2025-03-20 18:18:17'),
(252, 82, 26, 4, 'Nice hotel with great facilities. The staff was attentive, but the room could have been a bit cleaner upon arrival.', '2025-03-20 18:18:17'),
(253, 82, 27, 3, 'Good hotel overall, but the service was a little slow, especially at check-in. The hotel itself is fine, just a few minor improvements could make it better.', '2025-03-20 18:18:17'),
(254, 83, 28, 5, 'Fantastic experience here. The hotel was beautiful, and the service was exceptional. I would definitely stay again.', '2025-03-20 18:18:17'),
(255, 83, 29, 4, 'The location was ideal for sightseeing, and the hotel was very comfortable. I would have appreciated more variety in the breakfast menu though.', '2025-03-20 18:18:17'),
(256, 83, 30, 3, 'The hotel was okay, but I feel the price was a bit too high for the quality of the room. The amenities were good, though.', '2025-03-20 18:18:17'),
(257, 84, 31, 5, 'Amazing hotel experience! The staff were incredibly helpful and the room was exactly what I needed. I would return anytime.', '2025-03-20 18:18:17'),
(258, 84, 32, 4, 'Overall, a great hotel. The location is perfect, and the room was very comfortable. Could use more variety in the breakfast though.', '2025-03-20 18:18:17'),
(259, 84, 33, 5, 'Exceptional! From the friendly staff to the incredible decor, everything about this hotel was wonderful. A great place for a weekend getaway.', '2025-03-20 18:18:17'),
(260, 89, 1, 5, 'A fantastic learning environment! The professors are knowledgeable, and the facilities are top-notch. I’ve gained a lot from attending here.', '2025-03-20 18:19:15'),
(261, 89, 2, 4, 'A great educational institution with excellent resources. The campus is beautiful, and the teachers are friendly. I wish the courses were a bit more diverse.', '2025-03-20 18:19:15'),
(262, 89, 3, 3, 'Decent school with a good selection of classes, but the administration could be more organized. The location is perfect though.', '2025-03-20 18:19:15'),
(263, 90, 4, 5, 'I love this university! The teaching quality is outstanding, and the campus is well-maintained. It’s the perfect place to further your education.', '2025-03-20 18:19:15'),
(264, 90, 5, 4, 'Great school with lots of opportunities. The only downside was the parking situation. Other than that, it’s an excellent place to study.', '2025-03-20 18:19:15'),
(265, 90, 6, 5, 'Incredible campus, amazing professors, and a great community of students. I have learned so much in my time here and can’t wait for more.', '2025-03-20 18:19:15'),
(266, 91, 7, 4, 'Overall, a good experience. The courses are well-structured, and the faculty is approachable. The only issue is the overcrowded lecture halls.', '2025-03-20 18:19:15'),
(267, 91, 8, 3, 'It’s an okay institution, but there are better options out there. The facilities could use some upgrades, and the administrative processes are a bit slow.', '2025-03-20 18:19:15'),
(268, 91, 9, 5, 'Wonderful experience! The education is top-notch, and the environment is welcoming. I would highly recommend it to anyone looking to further their studies.', '2025-03-20 18:19:15'),
(269, 92, 10, 5, 'Fantastic! The campus is modern and welcoming. The courses are diverse, and the professors are always ready to help.', '2025-03-20 18:19:15'),
(270, 92, 11, 4, 'Great place for education, but the workload can sometimes be overwhelming. However, the professors are supportive and provide great feedback.', '2025-03-20 18:19:15'),
(271, 92, 12, 5, 'I’ve had an excellent time here. The education quality is superb, and the extracurricular activities offered are very engaging.', '2025-03-20 18:19:15'),
(272, 93, 13, 3, 'It’s a good school, but there’s room for improvement. Some of the facilities are outdated, and the library could be better stocked.', '2025-03-20 18:19:15'),
(273, 93, 14, 4, 'Solid educational institution with a wide range of programs. The teachers are knowledgeable, but sometimes the classes are a bit large.', '2025-03-20 18:19:15'),
(274, 93, 15, 5, 'I had a great time here! The professors are amazing, and the campus is a perfect environment for learning. I highly recommend it.', '2025-03-20 18:19:15'),
(275, 94, 16, 5, 'Best university I’ve attended. The quality of teaching is excellent, and the student community is friendly and inclusive.', '2025-03-20 18:19:15'),
(276, 94, 17, 4, 'Great education here. The faculty members are really helpful, but the campus could use more modern amenities for students.', '2025-03-20 18:19:15'),
(277, 94, 18, 3, 'It’s a good institution, but there were some issues with course scheduling, and some professors were difficult to approach.', '2025-03-20 18:19:15'),
(278, 95, 19, 5, 'I’ve learned so much here. The professors are experts in their fields, and the campus facilities are outstanding.', '2025-03-20 18:19:15'),
(279, 95, 20, 4, 'The campus is beautiful, and the quality of teaching is great. However, some of the buildings could use some renovations.', '2025-03-20 18:19:15'),
(280, 95, 21, 5, 'Excellent school! The faculty is very helpful, and the courses are well structured. It’s been a great place to pursue my education.', '2025-03-20 18:19:15'),
(281, 96, 22, 4, 'I’ve had a good experience overall, but the cafeteria could offer more variety in food options. The courses and professors, however, are fantastic.', '2025-03-20 18:19:15'),
(282, 96, 23, 3, 'It’s a decent school, but the facilities could be improved. The overall learning experience is good, but there is room for improvement.', '2025-03-20 18:19:15'),
(283, 96, 24, 5, 'Amazing school! The professors are passionate about teaching, and the students are supportive. It’s a great place to learn and grow.', '2025-03-20 18:19:15'),
(284, 97, 25, 4, 'Good educational institution with a lot of opportunities for students. The campus could use some modernization, but overall a great place to study.', '2025-03-20 18:19:15'),
(285, 97, 26, 5, 'Excellent university with top-tier facilities and excellent faculty. I’ve gained so much knowledge during my time here.', '2025-03-20 18:19:15'),
(286, 97, 27, 5, 'I love the diverse community and the quality of education here. The professors are really dedicated to helping students succeed.', '2025-03-20 18:19:15'),
(287, 98, 28, 5, 'This is a great university. The programs are diverse, and the quality of education is top-tier. I’ve learned so much in my time here.', '2025-03-20 18:19:15'),
(288, 98, 29, 4, 'Solid education and a great campus. The library and other facilities could be updated, but overall it’s a great institution to attend.', '2025-03-20 18:19:15'),
(289, 98, 30, 5, 'I’ve had a wonderful experience here. The faculty are great, and there’s a lot of student support to ensure success.', '2025-03-20 18:19:15'),
(290, 99, 31, 4, 'I’ve learned a lot during my time here, but the campus could use more green spaces for students to relax. Overall, it’s a great school.', '2025-03-20 18:19:15'),
(291, 99, 32, 3, 'It’s a good place for education, but I found the workload to be a bit too intense. The professors are great, though, and the campus is nice.', '2025-03-20 18:19:15'),
(292, 99, 33, 5, 'A great place to pursue your education. The programs are well structured, and the student life is very active and engaging.', '2025-03-20 18:19:15'),
(293, 100, 1, 5, 'This university provided me with everything I needed. From the professors to the campus facilities, everything exceeded my expectations.', '2025-03-20 18:19:15'),
(294, 100, 2, 4, 'A good educational institution. The campus is lovely, but I think the courses could benefit from a little more flexibility.', '2025-03-20 18:19:15'),
(295, 100, 3, 5, 'Great place for higher education. The professors are really supportive, and the academic environment is excellent.', '2025-03-20 18:19:15'),
(296, 101, 4, 4, 'Good school overall, though I feel some of the programs could be better organized. The campus and faculty are great though.', '2025-03-20 18:19:15'),
(297, 101, 5, 5, 'Amazing! The campus is beautiful, and the education is top-notch. I’ve had such a great experience here.', '2025-03-20 18:19:15'),
(298, 101, 6, 3, 'It’s a decent school, but the experience could be better with more career opportunities and extracurricular activities.', '2025-03-20 18:19:15'),
(299, 102, 7, 5, 'Wonderful university with excellent programs and a vibrant student life. The campus is always buzzing with energy, and the professors are very helpful.', '2025-03-20 18:19:15'),
(300, 102, 8, 4, 'Good university with lots of resources, but some of the buildings could use renovation. Overall, a great place to learn.', '2025-03-20 18:19:15'),
(301, 102, 9, 5, 'Best choice for higher education! The facilities are top-notch, and the faculty are always there to help students succeed.', '2025-03-20 18:19:15'),
(302, 103, 10, 4, 'Good place for education, but I wish there were more opportunities for hands-on learning. The professors are knowledgeable, though.', '2025-03-20 18:19:15'),
(303, 103, 11, 5, 'The university offers a wide variety of courses and has excellent staff. I had an incredible experience here.', '2025-03-20 18:19:15'),
(304, 103, 12, 3, 'I had an okay experience here. The professors were good, but I felt the campus could have offered more activities for students.', '2025-03-20 18:19:15'),
(305, 104, 1, 5, 'Great health clinic! The staff is incredibly caring and professional. The facilities are modern and clean. Highly recommended!', '2025-03-20 18:20:04'),
(306, 104, 2, 4, 'The clinic offers excellent care, and the staff is friendly. Wait times can sometimes be long, but overall a good experience.', '2025-03-20 18:20:04'),
(307, 104, 3, 5, 'Best healthcare service I’ve had. The doctors are knowledgeable, and the treatment I received was effective. Would definitely go back.', '2025-03-20 18:20:04'),
(308, 105, 4, 5, 'Amazing healthcare facility with top-notch doctors and nurses. The treatment I received was great, and the environment is welcoming.', '2025-03-20 18:20:04'),
(309, 105, 5, 4, 'Good clinic with attentive staff. I’ve had a positive experience with the doctors, but the waiting time could be improved.', '2025-03-20 18:20:04'),
(310, 105, 6, 5, 'I felt very well taken care of during my visit. The doctors are very professional, and the clinic is spotless. Highly recommend!', '2025-03-20 18:20:04'),
(311, 106, 7, 4, 'Great health center. The doctors are friendly and knowledgeable. The only downside is the long wait time for appointments.', '2025-03-20 18:20:04'),
(312, 106, 8, 5, 'Fantastic clinic with excellent staff. I had a quick and efficient consultation, and the doctor was very thorough in explaining everything.', '2025-03-20 18:20:04'),
(313, 106, 9, 3, 'The clinic is decent, but the customer service could be improved. The healthcare providers are good, though, and the clinic is clean.', '2025-03-20 18:20:04'),
(314, 107, 10, 5, 'I had a great experience here. The staff is extremely professional, and the doctor was very knowledgeable. Would definitely return!', '2025-03-20 18:20:04'),
(315, 107, 11, 4, 'Good healthcare service with great doctors, but the clinic could use more waiting room space. Overall, a positive experience.', '2025-03-20 18:20:04'),
(316, 107, 12, 5, 'Wonderful health clinic. The staff was warm and welcoming, and the doctors are top-notch. I felt very comfortable during my visit.', '2025-03-20 18:20:04'),
(317, 108, 13, 5, 'Amazing health center with modern facilities and caring staff. The doctors are fantastic and very thorough with their assessments.', '2025-03-20 18:20:04');
INSERT INTO `reviews` (`id`, `place_id`, `user_id`, `rating`, `review_text`, `created_at`) VALUES
(318, 108, 14, 4, 'Overall, a good clinic. The healthcare providers are great, but the clinic could be a bit more organized in terms of scheduling.', '2025-03-20 18:20:04'),
(319, 108, 15, 5, 'Best experience at a health clinic. The staff was professional and compassionate. I would definitely recommend this place to others.', '2025-03-20 18:20:04'),
(320, 109, 16, 4, 'I received good care at this clinic. The doctors were helpful, and the wait time was decent. I would recommend them for basic health needs.', '2025-03-20 18:20:04'),
(321, 109, 17, 3, 'The clinic provides decent healthcare, but I found the staff to be a little disorganized. The doctor was great, though.', '2025-03-20 18:20:04'),
(322, 109, 18, 5, 'Top-notch healthcare facility. The doctors and nurses are fantastic, and the clinic is very clean. Highly recommend this place!', '2025-03-20 18:20:04'),
(323, 110, 19, 4, 'Good experience overall. The staff was helpful, and the doctor was knowledgeable. I’d recommend this clinic to anyone looking for quality healthcare.', '2025-03-20 18:20:04'),
(324, 110, 20, 5, 'Excellent service! The doctors were very professional, and I felt comfortable throughout the entire visit. I’ll definitely return for future visits.', '2025-03-20 18:20:04'),
(325, 110, 21, 4, 'I had a pleasant visit here. The doctors were great, but the waiting area could use more seating. The rest of the clinic is very well kept.', '2025-03-20 18:20:04'),
(326, 111, 22, 5, 'I’ve been going here for a while, and every visit has been excellent. The staff is attentive, and the healthcare is top-quality.', '2025-03-20 18:20:04'),
(327, 111, 23, 4, 'Good health center with professional staff. The doctors are great, but it could be improved with a bit faster service during check-in.', '2025-03-20 18:20:04'),
(328, 111, 24, 5, 'One of the best healthcare facilities I’ve visited. The staff is very caring, and the doctors are experts in their fields.', '2025-03-20 18:20:04'),
(329, 112, 25, 5, 'I’m really impressed with this clinic. The service is prompt, and the staff is friendly. I’d highly recommend it to anyone in need of medical care.', '2025-03-20 18:20:04'),
(330, 112, 26, 4, 'The healthcare provided is great, but sometimes there is a bit of a wait for appointments. The doctors are very thorough, though.', '2025-03-20 18:20:04'),
(331, 112, 27, 5, 'Incredible clinic. The doctors are highly skilled, and the staff is very caring. I’ve had a great experience every time I’ve visited.', '2025-03-20 18:20:04'),
(332, 113, 28, 4, 'Nice healthcare facility. The doctors are great, but the reception staff can be a little slow at times. Overall, a good experience.', '2025-03-20 18:20:04'),
(333, 113, 29, 5, 'A wonderful experience from start to finish. The doctors are very knowledgeable, and I felt very well taken care of.', '2025-03-20 18:20:04'),
(334, 113, 30, 5, 'Fantastic healthcare service. The staff was efficient, and the doctor was very caring and explained everything in detail.', '2025-03-20 18:20:04'),
(335, 114, 31, 4, 'Great clinic with good doctors. The wait time is a bit long, but once you’re seen, the treatment is excellent.', '2025-03-20 18:20:04'),
(336, 114, 32, 5, 'Excellent health center! I received great care, and the staff was very friendly. I’m happy with my experience here.', '2025-03-20 18:20:04'),
(337, 114, 33, 5, 'I had an amazing experience. The doctor was very thorough and listened to all my concerns. The clinic is very clean and well-organized.', '2025-03-20 18:20:04'),
(338, 115, 1, 5, 'This health center is one of the best I’ve visited. The doctors are highly professional, and the staff is friendly and welcoming.', '2025-03-20 18:20:04'),
(339, 115, 2, 4, 'A great clinic with excellent doctors. The waiting time could be shorter, but the treatment I received was top-notch.', '2025-03-20 18:20:04'),
(340, 115, 3, 5, 'Fantastic clinic with caring staff. The doctors are experts, and I felt very comfortable during my visit. Highly recommend this place!', '2025-03-20 18:20:04'),
(341, 116, 4, 5, 'Great experience! The staff was friendly, and the doctor was very knowledgeable. I received excellent care, and the clinic is clean and modern.', '2025-03-20 18:20:04'),
(342, 116, 5, 4, 'I had a good experience here. The clinic is well-maintained, and the doctors are professional. The only downside is the wait time.', '2025-03-20 18:20:04'),
(343, 116, 6, 5, 'Top-quality healthcare. The doctor was thorough and attentive, and the clinic itself is very clean and comfortable.', '2025-03-20 18:20:04'),
(344, 117, 7, 4, 'A good clinic with knowledgeable staff. The doctor I saw was very helpful, but the process could be a bit more streamlined.', '2025-03-20 18:20:04'),
(345, 117, 8, 5, 'I had an excellent visit. The doctors are highly skilled, and the staff is friendly. The clinic is also well-maintained and clean.', '2025-03-20 18:20:04'),
(346, 117, 9, 5, 'Fantastic health facility. The staff made me feel very comfortable, and the doctor provided me with great care and attention.', '2025-03-20 18:20:04'),
(347, 118, 1, 5, 'Amazing coworking space! The environment is modern, and the facilities are top-notch. It’s perfect for productivity.', '2025-03-20 18:21:21'),
(348, 118, 2, 4, 'Great workspace with plenty of amenities. The Wi-Fi is fast, but it can get a bit crowded during peak hours.', '2025-03-20 18:21:21'),
(349, 118, 3, 5, 'I love working here! The space is clean, the staff is friendly, and the atmosphere is very inspiring. Highly recommend.', '2025-03-20 18:21:21'),
(350, 119, 4, 4, 'Good coworking space. The amenities are great, and there are many meeting rooms. The only downside is the lack of quiet zones.', '2025-03-20 18:21:21'),
(351, 119, 5, 5, 'I’ve been working here for a few months, and I couldn’t be happier. The space is clean, and there’s a great community of professionals.', '2025-03-20 18:21:21'),
(352, 119, 6, 5, 'Excellent workspace with everything you need to be productive. The coffee is great, and the staff is always helpful.', '2025-03-20 18:21:21'),
(353, 120, 7, 5, 'Great coworking environment. The workstations are spacious, and the internet is reliable. Perfect for remote workers.', '2025-03-20 18:21:21'),
(354, 120, 8, 4, 'A good space to work, but the noise level can be a bit much. The meeting rooms are great, though.', '2025-03-20 18:21:21'),
(355, 120, 9, 5, 'I love the vibe here. The environment is perfect for collaboration, and the facilities are excellent. Highly recommend this space.', '2025-03-20 18:21:21'),
(356, 121, 10, 5, 'This is my favorite coworking space. The people are friendly, and the space is well-equipped for work. The vibe is always positive.', '2025-03-20 18:21:21'),
(357, 121, 11, 4, 'Nice place to work, but I feel the seating arrangements could be improved. Overall, it’s a great place to get things done.', '2025-03-20 18:21:21'),
(358, 121, 12, 5, 'Incredible workspace with fast internet, great coffee, and all the amenities you could ask for. It’s a wonderful environment for working.', '2025-03-20 18:21:21'),
(359, 122, 13, 5, 'Fantastic coworking space! The office layout is well thought out, and the internet speed is excellent. The staff is always accommodating.', '2025-03-20 18:21:21'),
(360, 122, 14, 4, 'Great space for professionals. The only issue is that parking can be a challenge during peak hours, but otherwise, it’s an excellent environment.', '2025-03-20 18:21:21'),
(361, 122, 15, 5, 'I’ve had a great experience here. The space is modern, clean, and quiet enough to focus. Highly recommend it for anyone looking for a workspace.', '2025-03-20 18:21:21'),
(362, 123, 16, 4, 'Good workspace overall. There are a lot of great amenities, but I would like to see a few more private spaces for quiet work.', '2025-03-20 18:21:21'),
(363, 123, 17, 5, 'Love working here! The team is friendly, and the amenities are amazing. There’s a great community of like-minded professionals.', '2025-03-20 18:21:21'),
(364, 123, 18, 4, 'Decent space to work in, but I think it could use a few more common areas for socializing and networking. Otherwise, it’s great.', '2025-03-20 18:21:21'),
(365, 124, 19, 5, 'One of the best coworking spaces I’ve been to. The vibe is fantastic, and I love how quiet it is, allowing me to focus and get work done.', '2025-03-20 18:21:21'),
(366, 124, 20, 4, 'The space is good, but it could use more comfortable seating. The internet is great, and the staff is very helpful.', '2025-03-20 18:21:21'),
(367, 124, 21, 5, 'Excellent place to work! The design of the space encourages productivity, and there’s a great selection of workspaces.', '2025-03-20 18:21:21'),
(368, 125, 22, 4, 'I enjoy working here. The space is well-maintained, and the facilities are great. A few more quiet rooms would be ideal.', '2025-03-20 18:21:21'),
(369, 125, 23, 5, 'I absolutely love this place! The atmosphere is perfect for work, and the amenities are top of the line. Would definitely recommend.', '2025-03-20 18:21:21'),
(370, 125, 24, 5, 'Fantastic coworking space! Everything you need to work is here, and the staff are always friendly and ready to help.', '2025-03-20 18:21:21'),
(371, 126, 25, 5, 'Great space for remote work! The environment is inspiring, and the staff is always friendly and helpful. I get so much done here.', '2025-03-20 18:21:21'),
(372, 126, 26, 4, 'Good workspace. The only issue is the limited parking, but the space itself is wonderful for productivity.', '2025-03-20 18:21:21'),
(373, 126, 27, 5, 'Highly recommend this space for anyone looking to get work done. It’s spacious, comfortable, and the internet is super fast.', '2025-03-20 18:21:21'),
(374, 127, 28, 4, 'Great coworking environment, but it can get crowded during peak hours. The internet is fast, and the staff is always friendly.', '2025-03-20 18:21:21'),
(375, 127, 29, 5, 'Fantastic workspace with amazing amenities. The vibe here is great, and I feel very productive every time I come.', '2025-03-20 18:21:21'),
(376, 127, 30, 5, 'I’m so happy I joined this coworking space. It’s clean, comfortable, and filled with great people to collaborate with.', '2025-03-20 18:21:21'),
(377, 128, 31, 5, 'Excellent place to work. The amenities are great, and the staff is always friendly and helpful. It’s a fantastic workspace for remote workers.', '2025-03-20 18:21:21'),
(378, 128, 32, 4, 'A good place to work, but the space could be a little more organized. Otherwise, it’s a great environment for getting work done.', '2025-03-20 18:21:21'),
(379, 128, 33, 5, 'Love working here! The space is perfect for focused work, and the team is always willing to help if you need anything.', '2025-03-20 18:21:21'),
(380, 129, 1, 5, 'Amazing space! It’s bright, modern, and quiet enough to work without distractions. The amenities are great, and the atmosphere is welcoming.', '2025-03-20 18:21:21'),
(381, 129, 2, 4, 'This coworking space is great, though I wish they offered more meeting rooms. Overall, it’s a good place to get work done.', '2025-03-20 18:21:21'),
(382, 129, 3, 5, 'The best coworking space I’ve been to. The internet is fast, the coffee is great, and the staff is always friendly. Would highly recommend.', '2025-03-20 18:21:21'),
(383, 130, 4, 5, 'Fantastic workspace! I love how the layout promotes productivity, and the internet is lightning fast. Definitely one of the best coworking spaces in town.', '2025-03-20 18:21:21'),
(384, 130, 5, 4, 'A really good space to work in. The staff is helpful, and the atmosphere is professional. Would love to see more networking events.', '2025-03-20 18:21:21'),
(385, 130, 6, 5, 'This coworking space is perfect! It has everything I need to work efficiently, and the people here are friendly and welcoming.', '2025-03-20 18:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `review_comments`
--

CREATE TABLE `review_comments` (
  `id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_images`
--

CREATE TABLE `review_images` (
  `id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_images`
--

INSERT INTO `review_images` (`id`, `review_id`, `image_url`, `uploaded_at`) VALUES
(193, 1, 'assets/images/places/restaurants/R(1).jpg', '2025-03-22 08:57:32'),
(194, 1, 'assets/images/places/restaurants/R(2).jpg', '2025-03-22 08:57:32'),
(195, 2, 'assets/images/places/restaurants/R(2).jpg', '2025-03-22 08:57:32'),
(196, 3, 'assets/images/places/restaurants/R(3).jpg', '2025-03-22 08:57:32'),
(197, 7, 'assets/images/places/restaurants/R(5).jpg', '2025-03-22 08:57:32'),
(198, 8, 'assets/images/places/restaurants/R(9).jpg', '2025-03-22 08:57:32'),
(199, 22, 'assets/images/places/restaurants/R(8).jpg', '2025-03-22 08:57:32'),
(200, 24, 'assets/images/places/restaurants/R(12).jpg', '2025-03-22 08:57:32'),
(201, 16, 'assets/images/places/restaurants/R(19).jpg', '2025-03-22 08:57:32'),
(202, 11, 'assets/images/places/restaurants/R(14).jpg', '2025-03-22 08:57:32'),
(203, 11, 'assets/images/places/restaurants/R(18).jpg', '2025-03-22 08:57:32'),
(204, 25, 'assets/images/places/shopping/sh(7).jpg', '2025-03-22 08:57:32'),
(205, 25, 'assets/images/places/shopping/sh(8).jpg', '2025-03-22 08:57:32'),
(206, 25, 'assets/images/places/shopping/sh(9).jpg', '2025-03-22 08:57:32'),
(207, 28, 'assets/images/places/shopping/sh(10).jpg', '2025-03-22 08:57:32'),
(208, 31, 'assets/images/places/shopping/sh(11).jpg', '2025-03-22 08:57:32'),
(209, 32, 'assets/images/places/shopping/sh(12).jpg', '2025-03-22 08:57:32'),
(210, 15, 'assets/images/places/shopping/sh(13).jpg', '2025-03-22 08:57:32'),
(211, 38, 'assets/images/places/shopping/sh(14).jpg', '2025-03-22 08:57:32'),
(212, 42, 'assets/images/places/shopping/sh(15).jpg', '2025-03-22 08:57:32'),
(213, 51, 'assets/images/places/active-life/a(4).jpg', '2025-03-22 08:57:32'),
(214, 52, 'assets/images/places/active-life/a(5).jpg', '2025-03-22 08:57:32'),
(215, 54, 'assets/images/places/active-life/a(6).jpg', '2025-03-22 08:57:32'),
(216, 56, 'assets/images/places/active-life/a(7).jpg', '2025-03-22 08:57:32'),
(217, 60, 'assets/images/places/active-life/a(8).jpg', '2025-03-22 08:57:32'),
(218, 70, 'assets/images/places/home s/h(15).jpg', '2025-03-22 08:57:32'),
(219, 73, 'assets/images/places/home s/h(16).jpg', '2025-03-22 08:57:32'),
(220, 76, 'assets/images/places/home s/h(18).jpg', '2025-03-22 08:57:32'),
(221, 79, 'assets/images/places/home s/h(19).jpg', '2025-03-22 08:57:32'),
(222, 110, 'assets/images/places/Coffee/c(1).jpg', '2025-03-22 08:57:32'),
(223, 114, 'assets/images/places/Coffee/c(5).jpg', '2025-03-22 08:57:32'),
(224, 118, 'assets/images/places/Coffee/c(7).jpg', '2025-03-22 08:57:32'),
(225, 122, 'assets/images/places/Coffee/c(17).jpg', '2025-03-22 08:57:32'),
(226, 126, 'assets/images/places/Coffee/c(32).jpg', '2025-03-22 08:57:32'),
(227, 147, 'assets/images/places/pets/pets(1).jpg', '2025-03-22 08:57:32'),
(228, 150, 'assets/images/places/pets/pets(4).jpg', '2025-03-22 08:57:32'),
(229, 153, 'assets/images/places/pets/pets(8).jpg', '2025-03-22 08:57:32'),
(230, 156, 'assets/images/places/pets/pets(12).jpg', '2025-03-22 08:57:32'),
(231, 172, 'assets/images/places/plants/plants(1).jpg', '2025-03-22 08:57:32'),
(232, 178, 'assets/images/places/plants/plants(5).jpg', '2025-03-22 08:57:32'),
(233, 182, 'assets/images/places/plants/plants(10).jpg', '2025-03-22 08:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `review_likes`
--

CREATE TABLE `review_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_likes`
--

INSERT INTO `review_likes` (`id`, `user_id`, `review_id`, `created_at`) VALUES
(1, 32, 40, '2025-03-30 13:49:43'),
(2, 22, 358, '2025-03-30 13:49:43'),
(3, 24, 273, '2025-03-30 13:49:43'),
(4, 15, 33, '2025-03-30 13:49:43'),
(5, 4, 93, '2025-03-30 13:49:43'),
(6, 30, 313, '2025-03-30 13:49:43'),
(7, 12, 103, '2025-03-30 13:49:43'),
(8, 11, 289, '2025-03-30 13:49:43'),
(9, 28, 331, '2025-03-30 13:49:43'),
(10, 28, 218, '2025-03-30 13:49:43'),
(11, 12, 4, '2025-03-30 13:49:43'),
(12, 1, 29, '2025-03-30 13:49:43'),
(13, 11, 132, '2025-03-30 13:49:43'),
(14, 26, 312, '2025-03-30 13:49:43'),
(15, 25, 115, '2025-03-30 13:49:43'),
(16, 9, 145, '2025-03-30 13:49:43'),
(17, 4, 172, '2025-03-30 13:49:43'),
(18, 30, 33, '2025-03-30 13:49:43'),
(19, 26, 237, '2025-03-30 13:49:43'),
(20, 25, 356, '2025-03-30 13:49:43'),
(21, 12, 381, '2025-03-30 13:49:43'),
(22, 30, 184, '2025-03-30 13:49:43'),
(23, 24, 56, '2025-03-30 13:49:43'),
(24, 20, 175, '2025-03-30 13:49:43'),
(25, 18, 118, '2025-03-30 13:49:43'),
(26, 31, 282, '2025-03-30 13:49:43'),
(27, 29, 63, '2025-03-30 13:49:43'),
(28, 7, 182, '2025-03-30 13:49:43'),
(29, 26, 188, '2025-03-30 13:49:43'),
(30, 4, 13, '2025-03-30 13:49:43'),
(31, 29, 83, '2025-03-30 13:49:43'),
(32, 17, 308, '2025-03-30 13:49:43'),
(33, 18, 101, '2025-03-30 13:49:43'),
(34, 24, 286, '2025-03-30 13:49:43'),
(35, 20, 283, '2025-03-30 13:49:43'),
(36, 30, 114, '2025-03-30 13:49:43'),
(37, 26, 383, '2025-03-30 13:49:43'),
(38, 21, 78, '2025-03-30 13:49:43'),
(39, 4, 347, '2025-03-30 13:49:43'),
(40, 7, 106, '2025-03-30 13:49:43'),
(64, 9, 337, '2025-03-30 13:51:23'),
(65, 20, 126, '2025-03-30 13:51:23'),
(66, 29, 125, '2025-03-30 13:51:23'),
(67, 2, 91, '2025-03-30 13:51:23'),
(68, 2, 204, '2025-03-30 13:51:23'),
(69, 17, 365, '2025-03-30 13:51:23'),
(70, 7, 85, '2025-03-30 13:51:23'),
(71, 16, 254, '2025-03-30 13:51:23'),
(72, 30, 206, '2025-03-30 13:51:23'),
(73, 32, 76, '2025-03-30 13:51:23'),
(74, 4, 350, '2025-03-30 13:51:23'),
(75, 8, 188, '2025-03-30 13:51:23'),
(76, 24, 33, '2025-03-30 13:51:23'),
(77, 10, 78, '2025-03-30 13:51:23'),
(78, 5, 24, '2025-03-30 13:51:23'),
(79, 30, 138, '2025-03-30 13:51:23'),
(80, 3, 96, '2025-03-30 13:51:23'),
(81, 2, 183, '2025-03-30 13:51:23'),
(82, 8, 300, '2025-03-30 13:51:23'),
(83, 6, 206, '2025-03-30 13:51:23'),
(84, 5, 45, '2025-03-30 13:51:23'),
(85, 6, 162, '2025-03-30 13:51:23'),
(86, 21, 349, '2025-03-30 13:51:23'),
(87, 21, 165, '2025-03-30 13:51:23'),
(88, 9, 380, '2025-03-30 13:51:23'),
(89, 6, 333, '2025-03-30 13:51:23'),
(90, 28, 203, '2025-03-30 13:51:23'),
(91, 6, 82, '2025-03-30 13:51:23'),
(92, 20, 117, '2025-03-30 13:51:23'),
(93, 25, 319, '2025-03-30 13:51:23'),
(94, 30, 384, '2025-03-30 13:51:23'),
(95, 10, 180, '2025-03-30 13:51:23'),
(96, 16, 345, '2025-03-30 13:51:23'),
(97, 4, 319, '2025-03-30 13:51:23'),
(98, 28, 250, '2025-03-30 13:51:23'),
(99, 26, 340, '2025-03-30 13:51:23'),
(100, 4, 356, '2025-03-30 13:51:23'),
(101, 10, 240, '2025-03-30 13:51:23'),
(102, 9, 186, '2025-03-30 13:51:23'),
(103, 20, 212, '2025-03-30 13:51:23'),
(104, 32, 38, '2025-03-30 13:51:23'),
(105, 22, 348, '2025-03-30 13:51:23'),
(106, 20, 101, '2025-03-30 13:51:23'),
(107, 18, 327, '2025-03-30 13:51:23'),
(108, 22, 294, '2025-03-30 13:51:23'),
(109, 28, 323, '2025-03-30 13:51:23'),
(110, 24, 28, '2025-03-30 13:51:23'),
(111, 7, 310, '2025-03-30 13:51:23'),
(112, 14, 238, '2025-03-30 13:51:23'),
(113, 29, 193, '2025-03-30 13:51:23'),
(114, 30, 367, '2025-03-30 13:51:23'),
(115, 3, 222, '2025-03-30 13:51:23'),
(116, 21, 147, '2025-03-30 13:51:23'),
(117, 2, 10, '2025-03-30 13:51:23'),
(118, 1, 27, '2025-03-30 13:51:23'),
(119, 9, 22, '2025-03-30 13:51:23'),
(120, 18, 184, '2025-03-30 13:51:23'),
(121, 27, 207, '2025-03-30 13:51:23'),
(122, 10, 344, '2025-03-30 13:51:23'),
(123, 19, 47, '2025-03-30 13:51:23'),
(124, 31, 99, '2025-03-30 13:51:23'),
(125, 17, 310, '2025-03-30 13:51:23'),
(126, 16, 368, '2025-03-30 13:51:23'),
(127, 12, 349, '2025-03-30 13:51:23'),
(128, 16, 233, '2025-03-30 13:51:23'),
(129, 21, 120, '2025-03-30 13:51:23'),
(130, 23, 189, '2025-03-30 13:51:23'),
(131, 13, 185, '2025-03-30 13:51:23'),
(132, 8, 271, '2025-03-30 13:51:23'),
(133, 28, 11, '2025-03-30 13:51:23'),
(134, 22, 82, '2025-03-30 13:51:23'),
(135, 3, 303, '2025-03-30 13:51:23'),
(136, 23, 3, '2025-03-30 13:51:23'),
(137, 1, 20, '2025-03-30 13:51:23'),
(138, 7, 348, '2025-03-30 13:51:23'),
(139, 30, 266, '2025-03-30 13:51:23'),
(140, 27, 1, '2025-03-30 13:51:23'),
(141, 19, 305, '2025-03-30 13:51:23'),
(142, 10, 12, '2025-03-30 13:51:23'),
(143, 11, 166, '2025-03-30 13:51:23'),
(144, 8, 348, '2025-03-30 13:51:23'),
(145, 27, 101, '2025-03-30 13:51:23'),
(146, 31, 330, '2025-03-30 13:51:23'),
(147, 17, 351, '2025-03-30 13:51:23'),
(148, 3, 224, '2025-03-30 13:51:23'),
(149, 24, 325, '2025-03-30 13:51:23'),
(150, 3, 308, '2025-03-30 13:51:23'),
(151, 27, 233, '2025-03-30 13:51:23'),
(152, 21, 114, '2025-03-30 13:51:23'),
(153, 21, 60, '2025-03-30 13:51:23'),
(154, 32, 109, '2025-03-30 13:51:23'),
(155, 19, 371, '2025-03-30 13:51:23'),
(156, 5, 297, '2025-03-30 13:51:23'),
(157, 15, 366, '2025-03-30 13:51:23'),
(158, 14, 52, '2025-03-30 13:51:23'),
(159, 16, 376, '2025-03-30 13:51:23'),
(160, 15, 120, '2025-03-30 13:51:23'),
(161, 7, 45, '2025-03-30 13:51:23'),
(162, 32, 158, '2025-03-30 13:51:23'),
(163, 7, 283, '2025-03-30 13:51:23');

-- --------------------------------------------------------

--
-- Table structure for table `saved_places`
--

CREATE TABLE `saved_places` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_places`
--

INSERT INTO `saved_places` (`id`, `user_id`, `place_id`, `created_at`) VALUES
(1, 14, 90, '2025-03-30 13:55:25'),
(2, 8, 9, '2025-03-30 13:55:25'),
(3, 22, 10, '2025-03-30 13:55:25'),
(4, 14, 110, '2025-03-30 13:55:25'),
(5, 32, 36, '2025-03-30 13:55:25'),
(6, 17, 84, '2025-03-30 13:55:25'),
(7, 25, 100, '2025-03-30 13:55:25'),
(8, 21, 98, '2025-03-30 13:55:25'),
(9, 31, 53, '2025-03-30 13:55:25'),
(10, 8, 124, '2025-03-30 13:55:25'),
(11, 2, 51, '2025-03-30 13:55:25'),
(12, 27, 108, '2025-03-30 13:55:25'),
(13, 25, 23, '2025-03-30 13:55:25'),
(14, 23, 116, '2025-03-30 13:55:25'),
(15, 14, 50, '2025-03-30 13:55:25'),
(16, 23, 36, '2025-03-30 13:55:25'),
(17, 10, 91, '2025-03-30 13:55:25'),
(18, 19, 95, '2025-03-30 13:55:25'),
(19, 32, 75, '2025-03-30 13:55:25'),
(20, 1, 42, '2025-03-30 13:55:25'),
(21, 19, 116, '2025-03-30 13:55:25'),
(22, 24, 126, '2025-03-30 13:55:25'),
(23, 22, 44, '2025-03-30 13:55:25'),
(24, 24, 84, '2025-03-30 13:55:25'),
(25, 1, 20, '2025-03-30 13:55:25'),
(26, 24, 22, '2025-03-30 13:55:25'),
(27, 22, 101, '2025-03-30 13:55:25'),
(28, 30, 17, '2025-03-30 13:55:25'),
(29, 33, 64, '2025-03-30 13:55:25'),
(30, 18, 18, '2025-03-30 13:55:25'),
(31, 5, 30, '2025-03-30 13:55:25'),
(32, 25, 11, '2025-03-30 13:55:25'),
(33, 5, 62, '2025-03-30 13:55:25'),
(34, 31, 29, '2025-03-30 13:55:25'),
(35, 11, 130, '2025-03-30 13:55:25'),
(36, 33, 116, '2025-03-30 13:55:25'),
(37, 17, 116, '2025-03-30 13:55:25'),
(38, 30, 109, '2025-03-30 13:55:25'),
(39, 17, 125, '2025-03-30 13:55:25'),
(40, 11, 93, '2025-03-30 13:55:25'),
(41, 21, 122, '2025-03-30 13:55:25'),
(42, 28, 51, '2025-03-30 13:55:25'),
(43, 15, 128, '2025-03-30 13:55:25'),
(44, 21, 17, '2025-03-30 13:55:25'),
(45, 26, 72, '2025-03-30 13:55:25'),
(46, 14, 48, '2025-03-30 13:55:25'),
(47, 20, 118, '2025-03-30 13:55:25'),
(48, 24, 112, '2025-03-30 13:55:25'),
(49, 6, 31, '2025-03-30 13:55:25'),
(50, 23, 88, '2025-03-30 13:55:25'),
(51, 12, 97, '2025-03-30 13:55:25'),
(52, 22, 127, '2025-03-30 13:55:25'),
(53, 32, 116, '2025-03-30 13:55:25'),
(54, 19, 15, '2025-03-30 13:55:25'),
(55, 30, 20, '2025-03-30 13:55:25'),
(56, 2, 102, '2025-03-30 13:55:25'),
(57, 26, 69, '2025-03-30 13:55:25'),
(58, 11, 125, '2025-03-30 13:55:25'),
(59, 29, 56, '2025-03-30 13:55:25'),
(60, 19, 60, '2025-03-30 13:55:25'),
(61, 22, 120, '2025-03-30 13:55:25'),
(62, 21, 38, '2025-03-30 13:55:25'),
(63, 21, 36, '2025-03-30 13:55:25'),
(64, 16, 77, '2025-03-30 13:55:25'),
(65, 17, 99, '2025-03-30 13:55:25'),
(66, 10, 17, '2025-03-30 13:55:25'),
(67, 26, 66, '2025-03-30 13:55:25'),
(68, 7, 65, '2025-03-30 13:55:25'),
(69, 30, 118, '2025-03-30 13:55:25'),
(70, 30, 90, '2025-03-30 13:55:25'),
(71, 27, 1, '2025-03-30 13:55:25'),
(72, 19, 107, '2025-03-30 13:55:25'),
(73, 13, 66, '2025-03-30 13:55:25'),
(74, 12, 28, '2025-03-30 13:55:25'),
(75, 1, 66, '2025-03-30 13:55:25'),
(76, 15, 95, '2025-03-30 13:55:25'),
(77, 9, 24, '2025-03-30 13:55:25'),
(78, 4, 125, '2025-03-30 13:55:25'),
(79, 17, 81, '2025-03-30 13:55:25'),
(80, 20, 14, '2025-03-30 13:55:25'),
(81, 25, 45, '2025-03-30 13:55:25'),
(82, 18, 74, '2025-03-30 13:55:25'),
(83, 10, 97, '2025-03-30 13:55:25'),
(84, 29, 3, '2025-03-30 13:55:25'),
(85, 19, 93, '2025-03-30 13:55:25'),
(86, 30, 41, '2025-03-30 13:55:25'),
(87, 30, 74, '2025-03-30 13:55:25'),
(88, 5, 122, '2025-03-30 13:55:25'),
(89, 10, 78, '2025-03-30 13:55:25'),
(90, 5, 123, '2025-03-30 13:55:25'),
(91, 10, 73, '2025-03-30 13:55:25'),
(92, 32, 7, '2025-03-30 13:55:25'),
(93, 14, 124, '2025-03-30 13:55:25'),
(94, 16, 73, '2025-03-30 13:55:25'),
(95, 12, 8, '2025-03-30 13:55:25'),
(96, 9, 18, '2025-03-30 13:55:25'),
(97, 30, 9, '2025-03-30 13:55:25'),
(98, 21, 129, '2025-03-30 13:55:25'),
(99, 1, 22, '2025-03-30 13:55:25'),
(100, 26, 43, '2025-03-30 13:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `about_me` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `role` enum('Guest','Owner') DEFAULT 'Guest',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_private` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `profile_image`, `gender`, `about_me`, `location`, `role`, `created_at`, `is_private`) VALUES
(1, 'Ali', 'Al-Haddad', 'ali.ghaddad@example.com', 'password123', 'assets/images/profiles/m(1).jpg', 'Male', 'Hi, I’m Ali! I love discovering great local spots, whether it’s a cozy café, a hidden bookstore, or a restaurant with the best food in town. I enjoy sharing honest reviews to help others find amazing experiences. When I’m not trying new places, I’m usually working on tech-related topics or exploring programming.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(2, 'Fatima', 'Al-Abed', 'fatima.alabed@example.com', 'password123', 'assets/images/profiles/w(1).jpg', 'Female', 'Hi, I’m Fatima! Always on the lookout for new books to read and cool writing spots. I love sharing my thoughts and experiences with others, especially in literary spaces. When I’m not reading, I’m writing or learning more about the world of words!', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(3, 'Hassan', 'Ali', 'hassan.ali@example.com', 'password123', 'assets/images/profiles/m(2).jpg', 'Male', 'Hassan here! Passionate about tech, especially programming. Whether it’s a hidden tech hub or a cozy café where I can work on my next project, I love sharing my experiences with others. Excited to hear any recommendations you may have!', 'Zarqa, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(4, 'Reem', 'Al-Shami', 'reem.ashami@example.com', 'password123', 'assets/images/profiles/w(2).jpg', 'Female', 'Hey! I’m Reem, and I’m all about traveling and learning about new cultures. There’s nothing better than exploring new places, trying new foods, and sharing my experiences. Always on the hunt for the next great destination!', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(5, 'Yousef', 'Najjar', 'yousef.najjar@example.com', 'password123', NULL, 'Male', 'Hi, I’m Yousef! Passionate about technology and music, I love discovering places that allow me to enjoy both. Whether it’s a café with great Wi-Fi or a cozy bar with live music, I’m always looking for something new and exciting.', NULL, 'Guest', '2025-03-15 09:24:35', 'no'),
(6, 'Sara', 'Al-Hussein', 'sara.hussein@example.com', 'password123', NULL, 'Female', 'I’m Sara! I’m a fan of writing and reading, and I enjoy sharing my thoughts with others. Whether it’s at a quiet bookstore or a bustling café, I love finding places that inspire creativity and help me unwind!', 'Aqaba, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(7, 'Mahmoud', 'Al-Khateeb', 'mahmoud.khateeb@example.com', 'password123', NULL, 'Male', 'Mahmoud here! Passionate about programming and data analysis. I’m always discovering new spots to work, relax, and explore. On the lookout for hidden gems that spark creativity and offer a peaceful atmosphere.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(8, 'Layla', 'Al-Sabbah', 'layla.alsabbah@example.com', 'password123', 'assets/images/profiles/w(3).jpg', 'Female', 'Hi, I’m Layla! As a civil engineering student, I seek quiet spots where I can focus. When I’m not studying, I love exploring new places and discovering unique spots in the city.', 'Karak, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(9, 'Imad', 'Issa', 'imad.issa@example.com', 'password123', 'assets/images/profiles/m(3).jpg', 'Male', 'Imad here! I work in digital marketing and love exploring new places with a strong online presence. Whether it’s a café with great Wi-Fi or a tech hub, I’m always excited to discover new spots that help me grow in my career.', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(10, 'Huda', 'Al-Majali', 'huda.almajali@example.com', 'password123', NULL, NULL, 'Hey, I’m Huda! Art and music are my passions. I love exploring places with a creative vibe—whether it’s an art gallery or a café with live music. Always looking for inspiration!', NULL, 'Guest', '2025-03-15 09:24:35', 'no'),
(11, 'Tarek', 'Al-Maghribi', 'tarek.almaghroubi@example.com', 'password123', NULL, 'Male', 'I’m Tarek! A web developer who enjoys exploring new techniques and trends. When I’m not working on projects, I love finding spots to grab a coffee, work on code, or relax.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(12, 'Shrouq', 'Al-Hamd', 'shrouq.alhamd@example.com', 'password123', NULL, NULL, 'Hey, I’m Shrouq! As an engineering student, I’m always on the hunt for places to study and explore. Whether it’s a quiet library or a cozy café, I’m looking for the perfect environment to enhance my learning.', NULL, 'Guest', '2025-03-15 09:24:35', 'no'),
(13, 'Bassam', 'Al-Zghoul', 'bassam.alzghoul@example.com', 'password123', 'assets/images/profiles/m(4).jpg', 'Male', 'I’m Bassam! I’m passionate about programming and artificial intelligence, and I enjoy visiting tech hubs and innovative spaces. I love discovering places where I can both learn and relax at the same time.', 'Mafraq, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(14, 'Mona', 'Al-Taha', 'mona.althaha@example.com', 'password123', 'assets/images/profiles/w(4).jpg', 'Female', 'Hi! I’m Mona, passionate about design and technology. I love exploring places that inspire my creativity, whether it’s a design studio or a café with a modern vibe.', 'Salt, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(15, 'Khaled', 'Al-Shehadeh', 'khaled.alshehadeh@example.com', 'password123', NULL, NULL, 'I’m Khaled! I create digital content and love finding new spaces to fuel my creativity. Whether it’s a trendy café or a digital hub, I’m always excited to discover new spots.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(16, 'Lina', 'Al-Sabbagh', 'lina.alsabbagh@example.com', 'password123', NULL, 'Female', 'Lina here! Passionate about project management and photography. I love finding peaceful spots to get inspired, whether it’s a scenic viewpoint or a calm park.', 'Zarqa, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(17, 'Faisal', 'Al-Qudah', 'faisal.alqudah@example.com', 'password123', 'assets/images/profiles/m(5).jpg', 'Male', 'Hi! I’m Faisal, specializing in mobile app development. I enjoy discovering new spots that help me relax and focus. Whether it’s a coffee shop or a quiet park, I love finding new places to recharge and get creative.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(18, 'Nadine', 'Al-Fayez', 'nadine.alfayez@example.com', 'password123', NULL, NULL, 'I’m Nadine! A designer who loves modern aesthetics. I enjoy finding new spots with a cool, artistic vibe where I can work or unwind. Always looking for something fresh!', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(19, 'Rami', 'Al-Khalil', 'rami.alkhalil@example.com', 'password123', 'assets/images/profiles/m(6).jpg', 'Male', 'Rami here! I love web development and learning new frameworks. I visit tech hubs to find creative places to code, work, and unwind. Got any hidden gems? Let me know!', 'Aqaba, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(20, 'Dina', 'Al-Tal', 'dina.altar@example.com', 'password123', 'assets/images/profiles/w(5).jpg', 'Female', 'I’m Dina! As a content creator and digital marketer, I enjoy finding new places that inspire me. Whether it’s a lively tech space or a café with great ambiance, I’m always on the lookout for fresh ideas.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(21, 'Omar', 'Al-Jamal', 'omar.aljamal@example.com', 'password123', 'assets/images/profiles/m(7).jpg', 'Male', 'Hey, I’m Omar! A software engineer who loves solving complex problems. I find peace in quiet spots to code, brainstorm, and unwind. Whether it’s a café or park bench, I’m always looking for creative places to focus.', NULL, 'Guest', '2025-03-15 09:24:35', 'no'),
(22, 'Salma', 'Al-Hadid', 'salma.alhadid@example.com', 'password123', NULL, NULL, 'I’m Salma! Passionate about the environment and sustainability. I love discovering eco-friendly spots and businesses that align with my values. Whether it’s a green café or a sustainable store, I’m always finding places that make a positive impact.', 'Karak, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(23, 'Ziad', 'Al-Najjar', 'ziad.alnajjar@example.com', 'password123', NULL, 'Male', 'Ziad here! Passionate about sports and technology. I love finding new places to stay active, whether it’s a sports bar or a gym with a great vibe. When I’m not working, I’m usually exploring new spots to enjoy life.', 'Mafraq, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(24, 'Nour', 'Al-Razaz', 'nour.alrazaz@example.com', 'password123', 'assets/images/profiles/w(6).jpg', 'Female', 'Hi, I’m Nour! I enjoy learning about new cultures and languages. I love discovering places that reflect the world’s diversity, whether it’s a multicultural café or a cultural center. I’m always looking for fresh experiences.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(25, 'Yara', 'Al-Masri', 'yara.almasri@example.com', 'password123', 'assets/images/profiles/w(7).jpg', 'Female', 'Yara here! I’m a UX/UI designer who enjoys creative challenges. I love finding places that spark my creativity, whether it’s a design studio or a peaceful park. Always on the lookout for new spots to fuel my passion.', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(26, 'Tariq', 'Al-Qaisi', 'tariq.alqaisi@example.com', 'password123', 'assets/images/profiles/m(8).jpg', 'Male', 'I’m Tariq! A web developer who loves exploring new places that are both inspiring and productive. Whether it’s a coffee shop or a quiet corner to code, I’m always looking for the perfect spot to get creative.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(27, 'Maya', 'Al-Rashid', 'maya.alrashid@example.com', 'password123', 'assets/images/profiles/w(8).jpg', 'Female', 'Maya here! Passionate about graphic design and art, I love finding new places to explore my creative side. Whether it’s an art gallery, a museum, or a design studio, I’m always searching for fresh ideas and inspiration.', 'Zarqa, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(28, 'Mazen', 'Al-Raqqad', 'mazen.alraqqad@example.com', 'password123', 'assets/images/profiles/m(9).jpg', 'Male', 'Mazen here! Specializing in system architecture and cloud computing, I enjoy finding spots to relax and recharge. Whether it’s a quiet café or a peaceful park, I love discovering places to clear my mind.', NULL, 'Guest', '2025-03-15 09:24:35', 'no'),
(29, 'Jana', 'Al-Majali', 'jana.almajali@example.com', 'password123', 'assets/images/profiles/w(9).jpg', 'Female', 'Jana here! Studying economics and interested in data analysis. I love finding quiet places where I can study and work, whether it’s a library or a café with good Wi-Fi.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(30, 'Bashir', 'Al-Sharif', 'bashir.alsharif@example.com', 'password123', 'assets/images/profiles/m(10).jpg', 'Male', 'I’m Bashir! A software engineer who loves solving complex problems. I enjoy visiting tech hubs and finding places that challenge my mind. Know any cool spots to work or unwind? Let me know!', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(31, 'Sana', 'Al-Mawajda', 'sana.almowajda@example.com', 'password123', 'assets/images/profiles/w(10).jpg', 'Female', 'Hi, I’m Sana! I enjoy writing and digital marketing, always exploring new ways to connect with people online. When I’m not working, I’m brainstorming creative marketing ideas. If you’re into writing or marketing, let’s connect!', 'Mafraq, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(32, 'Zain', 'Al-Hamdan', 'zain.alhamdan@example.com', 'password123', NULL, 'Male', 'Hi, I’m Zain! I love creating innovative tech solutions, always focused on building something new and impactful. When I’m not developing, I’m researching the latest advancements in tech. If you love innovation, let’s chat!', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35', 'no'),
(33, 'Rania', 'Al-Jabari', 'rania.aljabari@example.com', 'password123', NULL, 'Female', 'Hi, I’m Rania! I’m passionate about education and technology, always looking for ways to combine these two fields. When I’m not learning, I’m teaching others and sharing my knowledge. Let’s connect if you share these interests!', 'Karak, Jordan', 'Guest', '2025-03-15 09:24:35', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_id` (`blog_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `opening_hours`
--
ALTER TABLE `opening_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `place_gallery`
--
ALTER TABLE `place_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `review_comments`
--
ALTER TABLE `review_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_id` (`review_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `review_images`
--
ALTER TABLE `review_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_images_ibfk_1` (`review_id`);

--
-- Indexes for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`review_id`),
  ADD KEY `review_id` (`review_id`);

--
-- Indexes for table `saved_places`
--
ALTER TABLE `saved_places`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`place_id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `opening_hours`
--
ALTER TABLE `opening_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1101;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `place_gallery`
--
ALTER TABLE `place_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=711;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT for table `review_comments`
--
ALTER TABLE `review_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_images`
--
ALTER TABLE `review_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `review_likes`
--
ALTER TABLE `review_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `saved_places`
--
ALTER TABLE `saved_places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `blog_comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `opening_hours`
--
ALTER TABLE `opening_hours`
  ADD CONSTRAINT `opening_hours_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `places_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `place_gallery`
--
ALTER TABLE `place_gallery`
  ADD CONSTRAINT `place_gallery_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_comments`
--
ALTER TABLE `review_comments`
  ADD CONSTRAINT `review_comments_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_images`
--
ALTER TABLE `review_images`
  ADD CONSTRAINT `review_images_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD CONSTRAINT `review_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_likes_ibfk_2` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_places`
--
ALTER TABLE `saved_places`
  ADD CONSTRAINT `saved_places_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_places_ibfk_2` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
