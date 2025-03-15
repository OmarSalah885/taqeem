-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 15, 2025 at 10:48 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `place_gallery`
--

CREATE TABLE `place_gallery` (
  `id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `profile_image`, `gender`, `about_me`, `location`, `role`, `created_at`) VALUES
(1, 'Ali', 'Al-Haddad', 'ali.ghaddad@example.com', 'password123', NULL, 'Male', 'Hi, I’m Ali! I love discovering great local spots, whether it’s a cozy café, a hidden bookstore, or a restaurant with the best food in town. I enjoy sharing honest reviews to help others find amazing experiences. When I’m not trying new places, I’m usually working on tech-related topics or exploring programming.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(2, 'Fatima', 'Al-Abed', 'fatima.alabed@example.com', 'password123', NULL, 'Female', 'Hi, I’m Fatima! Always on the lookout for new books to read and cool writing spots. I love sharing my thoughts and experiences with others, especially in literary spaces. When I’m not reading, I’m writing or learning more about the world of words!', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(3, 'Hassan', 'Ali', 'hassan.ali@example.com', 'password123', NULL, 'Male', 'Hassan here! Passionate about tech, especially programming. Whether it’s a hidden tech hub or a cozy café where I can work on my next project, I love sharing my experiences with others. Excited to hear any recommendations you may have!', 'Zarqa, Jordan', 'Guest', '2025-03-15 09:24:35'),
(4, 'Reem', 'Al-Shami', 'reem.ashami@example.com', 'password123', NULL, 'Female', 'Hey! I’m Reem, and I’m all about traveling and learning about new cultures. There’s nothing better than exploring new places, trying new foods, and sharing my experiences. Always on the hunt for the next great destination!', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(5, 'Yousef', 'Najjar', 'yousef.najjar@example.com', 'password123', NULL, 'Male', 'Hi, I’m Yousef! Passionate about technology and music, I love discovering places that allow me to enjoy both. Whether it’s a café with great Wi-Fi or a cozy bar with live music, I’m always looking for something new and exciting.', NULL, 'Guest', '2025-03-15 09:24:35'),
(6, 'Sara', 'Al-Hussein', 'sara.hussein@example.com', 'password123', NULL, 'Female', 'I’m Sara! I’m a fan of writing and reading, and I enjoy sharing my thoughts with others. Whether it’s at a quiet bookstore or a bustling café, I love finding places that inspire creativity and help me unwind!', 'Aqaba, Jordan', 'Guest', '2025-03-15 09:24:35'),
(7, 'Mahmoud', 'Al-Khateeb', 'mahmoud.khateeb@example.com', 'password123', NULL, 'Male', 'Mahmoud here! Passionate about programming and data analysis. I’m always discovering new spots to work, relax, and explore. On the lookout for hidden gems that spark creativity and offer a peaceful atmosphere.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(8, 'Layla', 'Al-Sabbah', 'layla.alsabbah@example.com', 'password123', NULL, 'Female', 'Hi, I’m Layla! As a civil engineering student, I seek quiet spots where I can focus. When I’m not studying, I love exploring new places and discovering unique spots in the city.', 'Karak, Jordan', 'Guest', '2025-03-15 09:24:35'),
(9, 'Imad', 'Issa', 'imad.issa@example.com', 'password123', NULL, 'Male', 'Imad here! I work in digital marketing and love exploring new places with a strong online presence. Whether it’s a café with great Wi-Fi or a tech hub, I’m always excited to discover new spots that help me grow in my career.', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(10, 'Huda', 'Al-Majali', 'huda.almajali@example.com', 'password123', NULL, NULL, 'Hey, I’m Huda! Art and music are my passions. I love exploring places with a creative vibe—whether it’s an art gallery or a café with live music. Always looking for inspiration!', NULL, 'Guest', '2025-03-15 09:24:35'),
(11, 'Tarek', 'Al-Maghribi', 'tarek.almaghroubi@example.com', 'password123', NULL, 'Male', 'I’m Tarek! A web developer who enjoys exploring new techniques and trends. When I’m not working on projects, I love finding spots to grab a coffee, work on code, or relax.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(12, 'Shrouq', 'Al-Hamd', 'shrouq.alhamd@example.com', 'password123', NULL, NULL, 'Hey, I’m Shrouq! As an engineering student, I’m always on the hunt for places to study and explore. Whether it’s a quiet library or a cozy café, I’m looking for the perfect environment to enhance my learning.', NULL, 'Guest', '2025-03-15 09:24:35'),
(13, 'Bassam', 'Al-Zghoul', 'bassam.alzghoul@example.com', 'password123', NULL, 'Male', 'I’m Bassam! I’m passionate about programming and artificial intelligence, and I enjoy visiting tech hubs and innovative spaces. I love discovering places where I can both learn and relax at the same time.', 'Mafraq, Jordan', 'Guest', '2025-03-15 09:24:35'),
(14, 'Mona', 'Al-Taha', 'mona.althaha@example.com', 'password123', NULL, 'Female', 'Hi! I’m Mona, passionate about design and technology. I love exploring places that inspire my creativity, whether it’s a design studio or a café with a modern vibe.', 'Salt, Jordan', 'Guest', '2025-03-15 09:24:35'),
(15, 'Khaled', 'Al-Shehadeh', 'khaled.alshehadeh@example.com', 'password123', NULL, NULL, 'I’m Khaled! I create digital content and love finding new spaces to fuel my creativity. Whether it’s a trendy café or a digital hub, I’m always excited to discover new spots.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(16, 'Lina', 'Al-Sabbagh', 'lina.alsabbagh@example.com', 'password123', NULL, 'Female', 'Lina here! Passionate about project management and photography. I love finding peaceful spots to get inspired, whether it’s a scenic viewpoint or a calm park.', 'Zarqa, Jordan', 'Guest', '2025-03-15 09:24:35'),
(17, 'Faisal', 'Al-Qudah', 'faisal.alqudah@example.com', 'password123', NULL, 'Male', 'Hi! I’m Faisal, specializing in mobile app development. I enjoy discovering new spots that help me relax and focus. Whether it’s a coffee shop or a quiet park, I love finding new places to recharge and get creative.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(18, 'Nadine', 'Al-Fayez', 'nadine.alfayez@example.com', 'password123', NULL, NULL, 'I’m Nadine! A designer who loves modern aesthetics. I enjoy finding new spots with a cool, artistic vibe where I can work or unwind. Always looking for something fresh!', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(19, 'Rami', 'Al-Khalil', 'rami.alkhalil@example.com', 'password123', NULL, 'Male', 'Rami here! I love web development and learning new frameworks. I visit tech hubs to find creative places to code, work, and unwind. Got any hidden gems? Let me know!', 'Aqaba, Jordan', 'Guest', '2025-03-15 09:24:35'),
(20, 'Dina', 'Al-Tal', 'dina.altar@example.com', 'password123', NULL, 'Female', 'I’m Dina! As a content creator and digital marketer, I enjoy finding new places that inspire me. Whether it’s a lively tech space or a café with great ambiance, I’m always on the lookout for fresh ideas.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(21, 'Omar', 'Al-Jamal', 'omar.aljamal@example.com', 'password123', NULL, 'Male', 'Hey, I’m Omar! A software engineer who loves solving complex problems. I find peace in quiet spots to code, brainstorm, and unwind. Whether it’s a café or park bench, I’m always looking for creative places to focus.', NULL, 'Guest', '2025-03-15 09:24:35'),
(22, 'Salma', 'Al-Hadid', 'salma.alhadid@example.com', 'password123', NULL, NULL, 'I’m Salma! Passionate about the environment and sustainability. I love discovering eco-friendly spots and businesses that align with my values. Whether it’s a green café or a sustainable store, I’m always finding places that make a positive impact.', 'Karak, Jordan', 'Guest', '2025-03-15 09:24:35'),
(23, 'Ziad', 'Al-Najjar', 'ziad.alnajjar@example.com', 'password123', NULL, 'Male', 'Ziad here! Passionate about sports and technology. I love finding new places to stay active, whether it’s a sports bar or a gym with a great vibe. When I’m not working, I’m usually exploring new spots to enjoy life.', 'Mafraq, Jordan', 'Guest', '2025-03-15 09:24:35'),
(24, 'Nour', 'Al-Razaz', 'nour.alrazaz@example.com', 'password123', NULL, 'Female', 'Hi, I’m Nour! I enjoy learning about new cultures and languages. I love discovering places that reflect the world’s diversity, whether it’s a multicultural café or a cultural center. I’m always looking for fresh experiences.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(25, 'Yara', 'Al-Masri', 'yara.almasri@example.com', 'password123', NULL, 'Female', 'Yara here! I’m a UX/UI designer who enjoys creative challenges. I love finding places that spark my creativity, whether it’s a design studio or a peaceful park. Always on the lookout for new spots to fuel my passion.', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(26, 'Tariq', 'Al-Qaisi', 'tariq.alqaisi@example.com', 'password123', NULL, 'Male', 'I’m Tariq! A web developer who loves exploring new places that are both inspiring and productive. Whether it’s a coffee shop or a quiet corner to code, I’m always looking for the perfect spot to get creative.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(27, 'Maya', 'Al-Rashid', 'maya.alrashid@example.com', 'password123', NULL, 'Female', 'Maya here! Passionate about graphic design and art, I love finding new places to explore my creative side. Whether it’s an art gallery, a museum, or a design studio, I’m always searching for fresh ideas and inspiration.', 'Zarqa, Jordan', 'Guest', '2025-03-15 09:24:35'),
(28, 'Mazen', 'Al-Raqqad', 'mazen.alraqqad@example.com', 'password123', NULL, 'Male', 'Mazen here! Specializing in system architecture and cloud computing, I enjoy finding spots to relax and recharge. Whether it’s a quiet café or a peaceful park, I love discovering places to clear my mind.', NULL, 'Guest', '2025-03-15 09:24:35'),
(29, 'Jana', 'Al-Majali', 'jana.almajali@example.com', 'password123', NULL, 'Female', 'Jana here! Studying economics and interested in data analysis. I love finding quiet places where I can study and work, whether it’s a library or a café with good Wi-Fi.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(30, 'Bashir', 'Al-Sharif', 'bashir.alsharif@example.com', 'password123', NULL, 'Male', 'I’m Bashir! A software engineer who loves solving complex problems. I enjoy visiting tech hubs and finding places that challenge my mind. Know any cool spots to work or unwind? Let me know!', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(31, 'Sana', 'Al-Mawajda', 'sana.almowajda@example.com', 'password123', NULL, 'Female', 'Hi, I’m Sana! I enjoy writing and digital marketing, always exploring new ways to connect with people online. When I’m not working, I’m brainstorming creative marketing ideas. If you’re into writing or marketing, let’s connect!', 'Mafraq, Jordan', 'Guest', '2025-03-15 09:24:35'),
(32, 'Zain', 'Al-Hamdan', 'zain.alhamdan@example.com', 'password123', NULL, 'Male', 'Hi, I’m Zain! I love creating innovative tech solutions, always focused on building something new and impactful. When I’m not developing, I’m researching the latest advancements in tech. If you love innovation, let’s chat!', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(33, 'Rania', 'Al-Jabari', 'rania.aljabari@example.com', 'password123', NULL, 'Female', 'Hi, I’m Rania! I’m passionate about education and technology, always looking for ways to combine these two fields. When I’m not learning, I’m teaching others and sharing my knowledge. Let’s connect if you share these interests!', 'Karak, Jordan', 'Guest', '2025-03-15 09:24:35');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opening_hours`
--
ALTER TABLE `opening_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `place_gallery`
--
ALTER TABLE `place_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_comments`
--
ALTER TABLE `review_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
