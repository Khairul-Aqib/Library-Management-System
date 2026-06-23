-- ──────────────────────────────────────────────────────────────
-- Library Management System — SAMPLE database schema
--
-- This is a SANITIZED dump for setup/demo purposes.
-- It contains the full table structure and the book catalog, but
-- NO real user accounts, password hashes, or borrowing history
-- (that data was removed to avoid publishing personal information).
--
-- Import this in phpMyAdmin to create the `library_management`
-- database, then register your own users through the app.
-- ──────────────────────────────────────────────────────────────

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookhistory`
--

CREATE TABLE `bookhistory` (
  `HistoryID` int(11) NOT NULL,
  `BookID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BorrowDate` date DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL,
  `BookCondition` varchar(255) NOT NULL,
  `FinePaid` decimal(10,2) DEFAULT 0.00,
  `DateReturned` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- (No borrowing history seeded — table intentionally left empty.)

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Author` varchar(100) DEFAULT NULL,
  `ISBN` varchar(20) DEFAULT NULL,
  `Publisher` varchar(100) DEFAULT NULL,
  `PublicationDate` date DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Quantity` int(11) DEFAULT 0,
  `Genre` varchar(50) DEFAULT NULL,
  `AmountBorrowed` int(11) DEFAULT 0,
  `Image` varchar(255) DEFAULT NULL,
  `ShelfLocation` varchar(50) DEFAULT NULL,
  `IsActive` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BookID`, `Title`, `Author`, `ISBN`, `Publisher`, `PublicationDate`, `Description`, `Quantity`, `Genre`, `AmountBorrowed`, `Image`, `ShelfLocation`, `IsActive`) VALUES
(1, 'Atomic Habits', 'James Clear', '9780735211292', 'Avery / Penguin Random House', '2018-12-10', NULL, 7, 'Self-help', -1, NULL, 'Books', 0),
(2, 'Ikigai: The Japanese Secret to a Long and Happy Life', 'Hector Gracia and Francasc Miralles', '9780143130727', 'Penguin Life', '2017-08-29', NULL, 3, 'Science Fiction', -1, NULL, 'Books', 0),
(3, 'test', 'test', 'test', 'test', '2025-01-14', NULL, 2, 'Horror', 0, NULL, 'test', 0),
(4, 'The Alchemist', 'Paulo Coelho', '9780061122415', 'HarperOne', '2006-05-01', 'A mystical story about following one\'s dream.', 5, 'Fantasy', 0, 'alchemist.jpg', 'A1', 1),
(5, 'Becoming', 'Michelle Obama', '9781524763138', 'Crown Publishing Group', '2018-11-13', 'An intimate, powerful memoir by the former First Lady of the United States.', 5, 'Autobiography', 3, 'becoming.jpg', 'B2', 1),
(6, 'The Book Thief', 'Markus Zusak', '9780375842207', 'Knopf Books for Young Readers', '2007-03-14', 'A story set in Nazi Germany narrated by Death itself.', 4, 'Historical Fiction', 3, 'book_thief.jpg', 'C3', 1),
(7, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', '9780590353427', 'Scholastic', '1997-09-01', 'The first book in the magical Harry Potter series.', 6, 'Fantasy', 4, 'harry_potter1.jpg', 'A2', 1),
(8, 'Long Walk to Freedom', 'Nelson Mandela', '9780316548182', 'Little, Brown and Company', '1994-01-01', 'Autobiography of Nelson Mandela, chronicling his life and struggles.', 2, 'Autobiography', 0, 'mandela.jpg', 'B4', 1),
(9, 'All the Light We Cannot See', 'Anthony Doerr', '9781476746586', 'Scribner', '2014-05-06', 'A blind French girl and a German boy whose paths collide in occupied France during WWII.', 3, 'Historical Fiction', 3, 'light_cannot_see.jpg', 'C6', 1),
(10, 'The Night Circus', 'Erin Morgenstern', '9780385534635', 'Doubleday', '2011-09-13', 'A fantastical story set around a magical circus that only operates at night, following two young illusionists bound in a magical competition.', 7, 'Fantasy', 0, 'nightcircus.jpg', 'A3', 1),
(13, 'Educated', 'Tara Westover', '9780399590504', 'Random House', '2018-02-20', 'A memoir recounting the author\'s struggle to break free from a strict upbringing and her pursuit of education, ultimately earning a PhD from Cambridge.', 4, 'Autobiography', 1, 'educated.jpg', 'B5', 1),
(14, 'The Name of the Wind', 'Patrick Rothfuss', '9780756404741', 'DAW Books', '2007-03-27', 'The first book in The Kingkiller Chronicle, following Kvothe, a gifted young man who grows up to become a legendary figure.', 4, 'Fantasy', 0, 'nameofthewind.jpg', 'A4', 1),
(15, 'The Diary of a Young Girl', 'Anne Frank', '9780553296983', 'Bantam Books', '1993-01-01', 'The poignant account of Anne Frank\'s life in hiding from the Nazis during World War II.', 4, 'Autobiography', 1, 'diary.jpg', 'B6', 1),
(16, 'The Nightingale', 'Kristin Hannah', '9780312577224', 'St. Martin\'s Press', '2015-02-03', 'The story of two French sisters who endure the hardships of World War II in Nazi-occupied France.', 5, 'Historical Fiction', 0, 'nightingale.jpg', 'C7', 1),
(17, 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', '9780439064873', 'Scholastic', '1998-07-02', 'The second book in the Harry Potter series, in which a dangerous force is unleashed within Hogwarts.', 5, 'Fantasy', 0, 'chamber.jpg', 'A5', 1),
(18, 'The Help', 'Kathryn Stockett', '9780399155345', 'Amy Einhorn Books', '2009-02-10', 'Set in 1960s Mississippi, three women collaborate to write a book exposing racism and inequality.', 5, 'Historical Fiction', 0, 'thehelp.jpg', 'C12', 1),
(19, 'Educating Rita', 'Willy Russell', '9780140273942', 'Penguin Books', '1980-01-01', 'A touching story of Rita, a working-class hairdresser who returns to education with the help of her tutor.', 5, 'Autobiography', 1, 'educatingrita.jpg', 'B10', 1),
(20, 'A Long Way Gone', 'Ishmael Beah', '9780374531263', 'Farrar, Straus and Giroux', '2007-02-13', 'The autobiography of a child soldier recounting his experiences in Sierra Leone during the civil war.', 5, 'Autobiography', 1, 'alongwaygone.jpg', 'B11', 1),
(21, 'The Shadow of the Wind', 'Carlos Ruiz Zafón', '9780143034902', 'Penguin Books', '2004-04-05', 'A gothic tale set in post-war Barcelona, following a young boy who discovers a forgotten book.', 5, 'Historical Fiction', 0, 'theshadowofthewind.jpg', 'C13', 1),
(22, 'The Catcher in the Rye', 'J.D. Salinger', '9780316769488', 'Little, Brown and Company', '1951-07-16', 'A classic novel about a disillusioned teenager, Holden Caulfield, navigating adolescence.', 4, 'Autobiography', 1, 'thecatcherintherye.jpg', 'B12', 1),
(23, 'The Hobbit', 'J.R.R. Tolkien', '9780547928227', 'Houghton Mifflin Harcourt', '1937-09-21', 'Bilbo Baggins embarks on a quest with a group of dwarves to reclaim treasure guarded by the dragon Smaug.', 4, 'Fantasy', 1, 'thehobbit.jpg', 'A11', 1),
(24, 'The Night Watch', 'Sarah Waters', '9781594202078', 'Riverhead Books', '2006-05-02', 'A novel set in WWII London, following the lives of four characters affected by the war.', 5, 'Historical Fiction', 0, 'thenightwatch.jpg', 'C14', 1),
(25, 'The Four Agreements', 'Don Miguel Ruiz', '9781878424310', 'Amber-Allen Publishing', '1997-11-07', 'A guide to personal freedom, offering four principles to create love and happiness in your life.', 4, 'Autobiography', 0, 'thefouragreements.jpg', 'B13', 1),
(41, 'The Great Gatsby', 'F. Scott Fitzgerald', '9780743273565', 'Scribner', '1925-04-10', 'A classic tale of the American Dream, following the mysterious millionaire Jay Gatsby.', 5, 'Historical Fiction', 0, 'thegreatgatsby.jpg', 'C15', 1),
(42, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', '9780062316097', 'Harper', '2015-02-10', 'An exploration of the history of humankind, from early Homo sapiens to modern society.', 4, 'Autobiography', 0, 'sapiens.jpg', 'B14', 1),
(43, 'Moby-Dick', 'Herman Melville', '9781851244422', 'Oxford University Press', '1851-10-18', 'The epic tale of Captain Ahab\'s obsessive quest for the white whale, Moby-Dick.', 4, 'Historical Fiction', 0, 'mobydick.jpg', 'C16', 1),
(44, '1984', 'George Orwell', '9780451524935', 'Signet Classics', '1949-06-08', 'A dystopian novel set in a totalitarian society ruled by Big Brother.', 6, 'Historical Fiction', 1, '1984.jpg', 'C17', 1),
(45, 'The Secret Garden', 'Frances Hodgson Burnett', '9781593081865', 'Barnes & Noble Classics', '1911-08-01', 'A children\'s novel about a young, orphaned girl who transforms a neglected garden and her own life.', 5, 'Fantasy', 1, 'thesecretgarden.jpg', 'A12', 1),
(46, 'The Grapes of Wrath', 'John Steinbeck', '9780143039433', 'Penguin Classics', '1939-04-14', 'The Joad family travels westward to California in search of a better life during the Great Depression.', 4, 'Historical Fiction', 1, 'thegrapesofwrath.jpg', 'C18', 1),
(47, 'The Picture of Dorian Gray', 'Oscar Wilde', '9780141439570', 'Penguin Classics', '1890-06-01', 'A philosophical and gothic novel exploring vanity, moral corruption, and indulgence.', 5, 'Historical Fiction', 1, 'thepictureofdoriangray.jpg', 'C21', 1),
(48, 'Brida', 'Paulo Coelho', '9780061542158', 'HarperOne', '2008-09-23', 'The story of Brida, a young girl who embarks on a journey to understand her destiny.', 4, 'Fantasy', 0, 'brida.jpg', 'A14', 1),
(49, 'The Kite Runner', 'Khaled Hosseini', '9781594631931', 'Riverhead Books', '2003-05-29', 'A story about two childhood friends and the turmoil caused by betrayal and redemption in Afghanistan.', 5, 'Historical Fiction', 1, 'thekitrunner.jpg', 'C22', 1),
(50, 'The Underground Railroad', 'Colson Whitehead', '9780385542364', 'Doubleday', '2016-08-02', 'A Pulitzer Prize-winning novel about Cora, an enslaved woman who escapes via the Underground Railroad.', 6, 'Historical Fiction', 0, 'theundergroundrailroad.jpg', 'C23', 1),
(51, 'The Fault in Our Stars', 'John Green', '9780525478812', 'Dutton Books', '2012-01-10', 'A poignant love story between two teenagers coping with cancer.', 5, 'Historical Fiction', 0, 'thefaultinourstars.jpg', 'C24', 1),
(52, 'The Wizard of Oz', 'L. Frank Baum', '9780486267655', 'Dover Publications', '1900-05-17', 'A timeless children\'s story about Dorothy, transported to the magical land of Oz.', 4, 'Fantasy', 0, 'thewizardofoz.jpg', 'A15', 1),
(53, 'The Chronicles of Narnia', 'C.S. Lewis', '9780066238500', 'HarperCollins', '2000-10-16', 'A series of seven high-fantasy novels set in the magical world of Narnia.', 6, 'Fantasy', 0, 'chroniclesofnarnia.jpg', 'A16', 1),
(54, 'The Brothers Karamazov', 'Fyodor Dostoevsky', '9780374528379', 'Farrar, Straus and Giroux', '1880-11-01', 'A philosophical novel exploring faith, doubt, free will, and morality.', 3, 'Historical Fiction', 1, 'thebrotherskaramazov.jpg', 'C25', 1),
(55, 'Harry Potter and the Prisoner of Azkaban', 'J.K. Rowling', '9780439136365', 'Scholastic', '1999-09-08', 'Harry returns for his third year at Hogwarts and uncovers secrets about his past.', 6, 'Fantasy', 0, 'harrypotter3.jpg', 'A17', 1),
(56, 'Harry Potter and the Goblet of Fire', 'J.K. Rowling', '9780439139601', 'Scholastic', '2000-07-08', 'Harry competes in the dangerous Triwizard Tournament.', 6, 'Fantasy', 0, 'harrypotter4.jpg', 'A18', 1),
(57, 'Harry Potter and the Order of the Phoenix', 'J.K. Rowling', '9780439358071', 'Scholastic', '2003-06-21', 'Harry leads a secret student group to fight against the Ministry\'s denial of Voldemort\'s return.', 5, 'Fantasy', 0, 'harrypotter5.jpg', 'A19', 1),
(58, 'Harry Potter and the Half-Blood Prince', 'J.K. Rowling', '9780439785969', 'Scholastic', '2005-07-16', 'Harry learns about Voldemort\'s past and begins the task of destroying the Horcruxes.', 6, 'Fantasy', 1, 'harrypotter6.jpg', 'A20', 1),
(59, 'Harry Potter and the Deathly Hallows', 'J.K. Rowling', '9780545139700', 'Scholastic', '2007-07-21', 'Harry, Ron, and Hermione embark on a quest to find and destroy Voldemort\'s Horcruxes.', 6, 'Fantasy', 1, 'harrypotter7.jpg', 'A21', 1),
(61, 'To Kill a Mockingbird', 'Harper Lee', '9780061120084', 'HarperCollins', '1960-07-11', 'Scout Finch witnesses her father defend an innocent black man, revealing deep racial prejudices.', 5, 'Historical Fiction', 0, 'tokillamockingbird2.jpg', 'C28', 1),
(62, 'The Road', 'Cormac McCarthy', '9780307387899', 'Vintage', '2006-09-26', 'A father and son struggle to survive in a post-apocalyptic world.', 5, 'Historical Fiction', 0, 'theroad.jpg', 'C29', 1),
(63, 'The Hitchhiker\'s Guide to the Galaxy', 'Douglas Adams', '9780345391803', 'Del Rey', '2001-10-12', 'An ordinary man embarks on an intergalactic adventure after the Earth is destroyed.', 5, 'Fantasy', 0, 'hitchhikersguide.jpg', 'A23', 1),
(64, 'Brave New World', 'Aldous Huxley', '9780060850524', 'Harper Perennial', '2005-12-01', 'A chilling view of a future society where people are controlled by technology.', 5, 'Historical Fiction', 0, 'bravenewworld.jpg', 'C31', 1),
(65, 'War and Peace', 'Leo Tolstoy', '9780140447934', 'Penguin Classics', '2007-09-23', 'A historical epic about the Napoleonic wars and the lives of Russian aristocrats.', 4, 'Historical Fiction', 1, 'warandpeace.jpg', 'C32', 1),
(66, 'The Shining', 'Stephen King', '9780307743657', 'Anchor', '2011-06-28', 'A psychological horror novel about a writer who becomes caretaker at the isolated Overlook Hotel.', 6, 'Fantasy', 0, 'theshining.jpg', 'A24', 1),
(67, 'Crime and Punishment', 'Fyodor Dostoevsky', '9780486454115', 'Dover Publications', '2007-03-01', 'A psychological novel exploring morality, guilt, and redemption.', 5, 'Historical Fiction', 0, 'crimeandpunishment.jpg', 'C33', 1),
(68, 'Frankenstein', 'Mary Shelley', '9780486282114', 'Dover Publications', '1994-06-01', 'A gothic horror novel about a scientist who creates a monster and the tragic consequences.', 5, 'Fantasy', 0, 'frankenstein.jpg', 'A25', 1),
(69, 'Anna Karenina', 'Leo Tolstoy', '9781853262715', 'Wordsworth Editions', '1993-01-01', 'A tragic love story set in the Russian aristocracy, exploring passion, betrayal, and social norms.', 4, 'Historical Fiction', 0, 'annakarenina.jpg', 'C35', 1),
(70, 'Dracula', 'Bram Stoker', '9780486421216', 'Dover Publications', '1996-01-01', 'A gothic horror classic about Count Dracula and the efforts to stop him.', 5, 'Fantasy', 1, 'dracula.jpg', 'A27', 1),
(71, 'Ulysses', 'James Joyce', '9780141182803', 'Penguin Classics', '2001-04-16', 'A modernist classic following Leopold Bloom and Stephen Dedalus through a single day in Dublin.', 5, 'Historical Fiction', 1, 'ulysses.jpg', 'C37', 1),
(72, 'Wuthering Heights', 'Emily Brontë', '9780141439556', 'Penguin Classics', '2003-01-01', 'A passionate and destructive love story set on the Yorkshire moors.', 5, 'Historical Fiction', 1, 'wutheringheights.jpg', 'C38', 1),
(73, 'Xenogenesis', 'Octavia Butler', '9780446603765', 'Grand Central Publishing', '1987-01-01', 'A novel exploring survival and genetic engineering through an uneasy alliance with an alien species.', 4, 'Fantasy', 0, 'xenogenesis.jpg', 'A29', 1),
(74, 'Zorba the Greek', 'Nikos Kazantzakis', '9780679760474', 'Vintage', '2002-10-01', 'A young intellectual befriends the free-spirited Zorba as they explore life, freedom, and love in Crete.', 5, 'Historical Fiction', 0, 'zorbathegreek.jpg', 'C39', 1),
(75, 'A Song of Ice and Fire: A Game of Thrones', 'George R.R. Martin', '9780553103540', 'Bantam Books', '1996-08-06', 'The first book in the epic fantasy series following the political dynamics of the Seven Kingdoms.', 3, 'Fantasy', 1, 'gameofthrones.jpg', 'A30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrowedbooks`
--

CREATE TABLE `borrowedbooks` (
  `BorrowID` int(11) NOT NULL,
  `BookID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BorrowDate` date DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL,
  `IsLate` tinyint(1) DEFAULT 0,
  `Fine` decimal(10,2) DEFAULT 0.00,
  `Status` varchar(20) DEFAULT 'Borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- (No borrowing records seeded — table intentionally left empty.)

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `BookID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(20) NOT NULL,
  `ICNumber` varchar(20) DEFAULT NULL,
  `pnumber` varchar(20) NOT NULL,
  `DateRegistered` date DEFAULT curdate(),
  `FullName` varchar(100) DEFAULT NULL,
  `Address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- (No user accounts seeded — register your own through the app.)
-- Optional: to create a demo admin (password: "admin"), uncomment below.
-- INSERT INTO `users` (`UserID`, `Email`, `Password`, `Role`, `ICNumber`, `pnumber`, `DateRegistered`, `FullName`, `Address`) VALUES
-- (1, 'admin@example.com', SHA1('admin'), 'admin', NULL, '', CURDATE(), 'Admin', 'Admin');

--
-- Indexes for dumped tables
--

ALTER TABLE `bookhistory`
  ADD PRIMARY KEY (`HistoryID`),
  ADD KEY `BookID` (`BookID`),
  ADD KEY `UserID` (`UserID`);

ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`),
  ADD UNIQUE KEY `ISBN` (`ISBN`);

ALTER TABLE `borrowedbooks`
  ADD PRIMARY KEY (`BorrowID`),
  ADD KEY `BookID` (`BookID`),
  ADD KEY `UserID` (`UserID`);

ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `BookID` (`BookID`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `ICNumber` (`ICNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `bookhistory`
  MODIFY `HistoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `books`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

ALTER TABLE `borrowedbooks`
  MODIFY `BorrowID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for dumped tables
--

ALTER TABLE `bookhistory`
  ADD CONSTRAINT `bookhistory_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`),
  ADD CONSTRAINT `bookhistory_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

ALTER TABLE `borrowedbooks`
  ADD CONSTRAINT `borrowedbooks_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`),
  ADD CONSTRAINT `borrowedbooks_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
