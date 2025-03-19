-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 19, 2025 at 09:30 AM
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
(6, 3, 5, 'It really does! Fun fact: the Treasury was featured in \"Indiana Jones and the Last Crusade.\" That scene where they ride up to it made it even more legendary. But in real life, it’s even more massive and intricate than I ever imagined!', 4, '2025-03-15 14:11:07'),
(7, 3, 6, 'I wish they allowed more preservation efforts in some areas. I read that parts of the rock are eroding due to weathering and increased tourism. It’s a delicate balance between keeping it accessible and protecting such a historic site.', NULL, '2025-03-15 14:11:07'),
(8, 3, 7, 'That’s a great point. From what I saw, they are taking conservation seriously, but with the number of tourists visiting each day, it’s definitely a challenge. I think limiting access to certain fragile areas might be a good idea in the future.', 6, '2025-03-15 14:11:07'),
(9, 3, 8, 'Is Petra very crowded during peak season? I’d love to visit, but I prefer exploring places when they’re not overly packed with tourists. Are there any specific months or times of the day when it’s less crowded?', NULL, '2025-03-15 14:11:07'),
(10, 3, 9, 'Yes, it can get quite busy, especially around midday when most tour groups arrive. The best way to avoid crowds is to go early in the morning or later in the afternoon. Also, visiting in the off-season, like late autumn or early spring, helps avoid the extreme heat and peak tourist rush.', 8, '2025-03-15 14:11:07'),
(11, 7, 1, 'Amman sounds like a dream for food lovers! I’ve always wanted to try authentic Jordanian cuisine. What’s the best place for a traditional Jordanian breakfast?', NULL, '2025-03-15 14:13:24'),
(12, 7, 2, 'If you’re looking for a classic Jordanian breakfast, you have to visit Hashem Restaurant! Their hummus and falafel are legendary, and it’s a favorite among both locals and tourists.', 1, '2025-03-15 14:13:24'),
(13, 7, 3, 'I love street food! Shawarma and falafel are some of my favorites. Are there any specific places in Amman that are known for having the best street food?', NULL, '2025-03-15 14:13:24'),
(14, 18, 10, 'Aqaba sounds like an amazing destination! I’ve always wanted to go diving in the Red Sea. How difficult is it for a beginner to get started with diving there?', NULL, '2025-03-15 14:17:23'),
(15, 18, 2, 'It’s actually a great place for beginners! There are plenty of dive shops in Aqaba that offer introductory courses, and the waters are calm and clear, making it a perfect spot to learn.', 1, '2025-03-15 14:17:23'),
(16, 18, 30, 'The Japanese Gardens dive site looks stunning! Has anyone been there? I’d love to know what the experience is like and if it’s suitable for intermediate divers.', NULL, '2025-03-15 14:17:23'),
(17, 18, 19, 'Yes! I dove there last year, and it was absolutely breathtaking. The coral formations are vibrant, and there are so many colorful fish. If you’re an intermediate diver, you’ll love it—it’s not too deep, but still full of marine life.', 3, '2025-03-15 14:17:23'),
(18, 18, 24, 'Snorkeling sounds like a great option too! Are there specific locations in Aqaba that are best for snorkeling, or can you just go anywhere along the coast?', NULL, '2025-03-15 14:17:23'),
(19, 14, 12, 'The Dead Sea has always fascinated me! I’ve heard that the high salt content makes it impossible to sink, but is it safe for people with sensitive skin?', NULL, '2025-03-15 14:20:31'),
(20, 14, 16, 'Yes, it’s generally safe, but if you have any cuts or sensitive skin, the salt can cause a stinging sensation. It’s best to rinse off with fresh water after floating to avoid irritation.', 1, '2025-03-15 14:20:31'),
(21, 14, 11, 'I love the idea of a natural spa experience! Has anyone tried the Dead Sea mud treatments? Do they really help with skin conditions?', NULL, '2025-03-15 14:20:31'),
(22, 14, 26, 'I tried it last summer, and my skin felt so smooth afterward! The minerals in the mud are great for exfoliation, and it helped with some dryness I had. Definitely worth trying!', 3, '2025-03-15 14:20:31');

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
(1, 'Ali', 'Al-Haddad', 'ali.ghaddad@example.com', 'password123', 'assets/images/profiles/m(1).jpg', 'Male', 'Hi, I’m Ali! I love discovering great local spots, whether it’s a cozy café, a hidden bookstore, or a restaurant with the best food in town. I enjoy sharing honest reviews to help others find amazing experiences. When I’m not trying new places, I’m usually working on tech-related topics or exploring programming.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(2, 'Fatima', 'Al-Abed', 'fatima.alabed@example.com', 'password123', 'assets/images/profiles/w(1).jpg', 'Female', 'Hi, I’m Fatima! Always on the lookout for new books to read and cool writing spots. I love sharing my thoughts and experiences with others, especially in literary spaces. When I’m not reading, I’m writing or learning more about the world of words!', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(3, 'Hassan', 'Ali', 'hassan.ali@example.com', 'password123', 'assets/images/profiles/m(2).jpg', 'Male', 'Hassan here! Passionate about tech, especially programming. Whether it’s a hidden tech hub or a cozy café where I can work on my next project, I love sharing my experiences with others. Excited to hear any recommendations you may have!', 'Zarqa, Jordan', 'Guest', '2025-03-15 09:24:35'),
(4, 'Reem', 'Al-Shami', 'reem.ashami@example.com', 'password123', 'assets/images/profiles/w(2).jpg', 'Female', 'Hey! I’m Reem, and I’m all about traveling and learning about new cultures. There’s nothing better than exploring new places, trying new foods, and sharing my experiences. Always on the hunt for the next great destination!', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(5, 'Yousef', 'Najjar', 'yousef.najjar@example.com', 'password123', NULL, 'Male', 'Hi, I’m Yousef! Passionate about technology and music, I love discovering places that allow me to enjoy both. Whether it’s a café with great Wi-Fi or a cozy bar with live music, I’m always looking for something new and exciting.', NULL, 'Guest', '2025-03-15 09:24:35'),
(6, 'Sara', 'Al-Hussein', 'sara.hussein@example.com', 'password123', NULL, 'Female', 'I’m Sara! I’m a fan of writing and reading, and I enjoy sharing my thoughts with others. Whether it’s at a quiet bookstore or a bustling café, I love finding places that inspire creativity and help me unwind!', 'Aqaba, Jordan', 'Guest', '2025-03-15 09:24:35'),
(7, 'Mahmoud', 'Al-Khateeb', 'mahmoud.khateeb@example.com', 'password123', NULL, 'Male', 'Mahmoud here! Passionate about programming and data analysis. I’m always discovering new spots to work, relax, and explore. On the lookout for hidden gems that spark creativity and offer a peaceful atmosphere.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(8, 'Layla', 'Al-Sabbah', 'layla.alsabbah@example.com', 'password123', 'assets/images/profiles/w(3).jpg', 'Female', 'Hi, I’m Layla! As a civil engineering student, I seek quiet spots where I can focus. When I’m not studying, I love exploring new places and discovering unique spots in the city.', 'Karak, Jordan', 'Guest', '2025-03-15 09:24:35'),
(9, 'Imad', 'Issa', 'imad.issa@example.com', 'password123', 'assets/images/profiles/m(3).jpg', 'Male', 'Imad here! I work in digital marketing and love exploring new places with a strong online presence. Whether it’s a café with great Wi-Fi or a tech hub, I’m always excited to discover new spots that help me grow in my career.', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(10, 'Huda', 'Al-Majali', 'huda.almajali@example.com', 'password123', NULL, NULL, 'Hey, I’m Huda! Art and music are my passions. I love exploring places with a creative vibe—whether it’s an art gallery or a café with live music. Always looking for inspiration!', NULL, 'Guest', '2025-03-15 09:24:35'),
(11, 'Tarek', 'Al-Maghribi', 'tarek.almaghroubi@example.com', 'password123', NULL, 'Male', 'I’m Tarek! A web developer who enjoys exploring new techniques and trends. When I’m not working on projects, I love finding spots to grab a coffee, work on code, or relax.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(12, 'Shrouq', 'Al-Hamd', 'shrouq.alhamd@example.com', 'password123', NULL, NULL, 'Hey, I’m Shrouq! As an engineering student, I’m always on the hunt for places to study and explore. Whether it’s a quiet library or a cozy café, I’m looking for the perfect environment to enhance my learning.', NULL, 'Guest', '2025-03-15 09:24:35'),
(13, 'Bassam', 'Al-Zghoul', 'bassam.alzghoul@example.com', 'password123', 'assets/images/profiles/m(4).jpg', 'Male', 'I’m Bassam! I’m passionate about programming and artificial intelligence, and I enjoy visiting tech hubs and innovative spaces. I love discovering places where I can both learn and relax at the same time.', 'Mafraq, Jordan', 'Guest', '2025-03-15 09:24:35'),
(14, 'Mona', 'Al-Taha', 'mona.althaha@example.com', 'password123', 'assets/images/profiles/w(4).jpg', 'Female', 'Hi! I’m Mona, passionate about design and technology. I love exploring places that inspire my creativity, whether it’s a design studio or a café with a modern vibe.', 'Salt, Jordan', 'Guest', '2025-03-15 09:24:35'),
(15, 'Khaled', 'Al-Shehadeh', 'khaled.alshehadeh@example.com', 'password123', NULL, NULL, 'I’m Khaled! I create digital content and love finding new spaces to fuel my creativity. Whether it’s a trendy café or a digital hub, I’m always excited to discover new spots.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(16, 'Lina', 'Al-Sabbagh', 'lina.alsabbagh@example.com', 'password123', NULL, 'Female', 'Lina here! Passionate about project management and photography. I love finding peaceful spots to get inspired, whether it’s a scenic viewpoint or a calm park.', 'Zarqa, Jordan', 'Guest', '2025-03-15 09:24:35'),
(17, 'Faisal', 'Al-Qudah', 'faisal.alqudah@example.com', 'password123', 'assets/images/profiles/m(5).jpg', 'Male', 'Hi! I’m Faisal, specializing in mobile app development. I enjoy discovering new spots that help me relax and focus. Whether it’s a coffee shop or a quiet park, I love finding new places to recharge and get creative.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(18, 'Nadine', 'Al-Fayez', 'nadine.alfayez@example.com', 'password123', NULL, NULL, 'I’m Nadine! A designer who loves modern aesthetics. I enjoy finding new spots with a cool, artistic vibe where I can work or unwind. Always looking for something fresh!', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(19, 'Rami', 'Al-Khalil', 'rami.alkhalil@example.com', 'password123', 'assets/images/profiles/m(6).jpg', 'Male', 'Rami here! I love web development and learning new frameworks. I visit tech hubs to find creative places to code, work, and unwind. Got any hidden gems? Let me know!', 'Aqaba, Jordan', 'Guest', '2025-03-15 09:24:35'),
(20, 'Dina', 'Al-Tal', 'dina.altar@example.com', 'password123', 'assets/images/profiles/w(5).jpg', 'Female', 'I’m Dina! As a content creator and digital marketer, I enjoy finding new places that inspire me. Whether it’s a lively tech space or a café with great ambiance, I’m always on the lookout for fresh ideas.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(21, 'Omar', 'Al-Jamal', 'omar.aljamal@example.com', 'password123', 'assets/images/profiles/m(7).jpg', 'Male', 'Hey, I’m Omar! A software engineer who loves solving complex problems. I find peace in quiet spots to code, brainstorm, and unwind. Whether it’s a café or park bench, I’m always looking for creative places to focus.', NULL, 'Guest', '2025-03-15 09:24:35'),
(22, 'Salma', 'Al-Hadid', 'salma.alhadid@example.com', 'password123', NULL, NULL, 'I’m Salma! Passionate about the environment and sustainability. I love discovering eco-friendly spots and businesses that align with my values. Whether it’s a green café or a sustainable store, I’m always finding places that make a positive impact.', 'Karak, Jordan', 'Guest', '2025-03-15 09:24:35'),
(23, 'Ziad', 'Al-Najjar', 'ziad.alnajjar@example.com', 'password123', NULL, 'Male', 'Ziad here! Passionate about sports and technology. I love finding new places to stay active, whether it’s a sports bar or a gym with a great vibe. When I’m not working, I’m usually exploring new spots to enjoy life.', 'Mafraq, Jordan', 'Guest', '2025-03-15 09:24:35'),
(24, 'Nour', 'Al-Razaz', 'nour.alrazaz@example.com', 'password123', 'assets/images/profiles/w(6).jpg', 'Female', 'Hi, I’m Nour! I enjoy learning about new cultures and languages. I love discovering places that reflect the world’s diversity, whether it’s a multicultural café or a cultural center. I’m always looking for fresh experiences.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(25, 'Yara', 'Al-Masri', 'yara.almasri@example.com', 'password123', 'assets/images/profiles/w(7).jpg', 'Female', 'Yara here! I’m a UX/UI designer who enjoys creative challenges. I love finding places that spark my creativity, whether it’s a design studio or a peaceful park. Always on the lookout for new spots to fuel my passion.', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(26, 'Tariq', 'Al-Qaisi', 'tariq.alqaisi@example.com', 'password123', 'assets/images/profiles/m(8).jpg', 'Male', 'I’m Tariq! A web developer who loves exploring new places that are both inspiring and productive. Whether it’s a coffee shop or a quiet corner to code, I’m always looking for the perfect spot to get creative.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(27, 'Maya', 'Al-Rashid', 'maya.alrashid@example.com', 'password123', 'assets/images/profiles/w(8).jpg', 'Female', 'Maya here! Passionate about graphic design and art, I love finding new places to explore my creative side. Whether it’s an art gallery, a museum, or a design studio, I’m always searching for fresh ideas and inspiration.', 'Zarqa, Jordan', 'Guest', '2025-03-15 09:24:35'),
(28, 'Mazen', 'Al-Raqqad', 'mazen.alraqqad@example.com', 'password123', 'assets/images/profiles/m(9).jpg', 'Male', 'Mazen here! Specializing in system architecture and cloud computing, I enjoy finding spots to relax and recharge. Whether it’s a quiet café or a peaceful park, I love discovering places to clear my mind.', NULL, 'Guest', '2025-03-15 09:24:35'),
(29, 'Jana', 'Al-Majali', 'jana.almajali@example.com', 'password123', 'assets/images/profiles/w(9).jpg', 'Female', 'Jana here! Studying economics and interested in data analysis. I love finding quiet places where I can study and work, whether it’s a library or a café with good Wi-Fi.', 'Amman, Jordan', 'Guest', '2025-03-15 09:24:35'),
(30, 'Bashir', 'Al-Sharif', 'bashir.alsharif@example.com', 'password123', 'assets/images/profiles/m(10).jpg', 'Male', 'I’m Bashir! A software engineer who loves solving complex problems. I enjoy visiting tech hubs and finding places that challenge my mind. Know any cool spots to work or unwind? Let me know!', 'Irbid, Jordan', 'Guest', '2025-03-15 09:24:35'),
(31, 'Sana', 'Al-Mawajda', 'sana.almowajda@example.com', 'password123', 'assets/images/profiles/w(10).jpg', 'Female', 'Hi, I’m Sana! I enjoy writing and digital marketing, always exploring new ways to connect with people online. When I’m not working, I’m brainstorming creative marketing ideas. If you’re into writing or marketing, let’s connect!', 'Mafraq, Jordan', 'Guest', '2025-03-15 09:24:35'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
