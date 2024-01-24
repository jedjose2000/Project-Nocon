-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2024 at 01:04 PM
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
-- Database: `db_projectnocon`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccounts`
--

CREATE TABLE `tblaccounts` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userLevel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `firstTimeLogin` int(1) NOT NULL DEFAULT 1,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblaccounts`
--

INSERT INTO `tblaccounts` (`id`, `username`, `password`, `userLevel`, `email`, `otp`, `firstTimeLogin`, `status`) VALUES
(1, 'admin', '$2y$10$kIPVD/M4z8hviAqEr5xesuR.RSSg1cO.O4H31kpqAMRV.26xHjdI2', '1', 'jedjose2000@gmail.com', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `categoryId` int(255) NOT NULL,
  `categoryName` varchar(255) NOT NULL,
  `categoryDescription` varchar(255) NOT NULL,
  `isCategoryArchived` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`categoryId`, `categoryName`, `categoryDescription`, `isCategoryArchived`) VALUES
(1, 'Food', 'Test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblinventory`
--

CREATE TABLE `tblinventory` (
  `inventoryId` int(10) NOT NULL,
  `productID` int(10) NOT NULL,
  `supplierID` int(10) NOT NULL,
  `totalQuantity` int(10) NOT NULL,
  `damaged` int(10) NOT NULL,
  `lost` int(10) NOT NULL,
  `expired` int(10) NOT NULL,
  `sold` int(10) NOT NULL,
  `available` int(10) NOT NULL,
  `returned` int(255) NOT NULL,
  `expirationDate` date NOT NULL,
  `isInventoryArchived` int(10) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblinventory`
--

INSERT INTO `tblinventory` (`inventoryId`, `productID`, `supplierID`, `totalQuantity`, `damaged`, `lost`, `expired`, `sold`, `available`, `returned`, `expirationDate`, `isInventoryArchived`, `status`) VALUES
(1, 1, 0, 205, 20, 0, 0, 0, 0, 0, '2024-01-30', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tblpermissions`
--

CREATE TABLE `tblpermissions` (
  `id` int(11) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  `function` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpermissions`
--

INSERT INTO `tblpermissions` (`id`, `module`, `function`) VALUES
(1, 'orderListAdd', 'Add Order'),
(2, 'orderListUpdate', 'Update Order'),
(3, 'orderListArchive', 'Archive Order'),
(4, 'supplierListAdd', 'Add Supplier'),
(5, 'supplierListUpdate', 'Update Supplier'),
(6, 'supplierListArchive', 'Archive Supplier'),
(7, 'productListAdd', 'Add Product'),
(8, 'productListUpdate', 'Update Product'),
(9, 'productListArchive', 'Archive Product'),
(10, 'productListView', 'View Product'),
(11, 'supplierListView', 'View Supplier'),
(12, 'orderListView', 'View Order');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `productId` int(255) NOT NULL,
  `productCode` varchar(255) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productBrand` varchar(255) NOT NULL,
  `categoryID` int(255) NOT NULL,
  `productDescription` longtext NOT NULL,
  `unit` varchar(255) NOT NULL,
  `willExpire` varchar(10) NOT NULL,
  `buyPrice` int(10) NOT NULL,
  `sellPrice` int(10) NOT NULL,
  `clq` int(10) NOT NULL,
  `isProductArchived` int(10) NOT NULL DEFAULT 0,
  `isInventory` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`productId`, `productCode`, `productName`, `productBrand`, `categoryID`, `productDescription`, `unit`, `willExpire`, `buyPrice`, `sellPrice`, `clq`, `isProductArchived`, `isInventory`) VALUES
(1, 'PRD-00001', 'Tender Juicy', 'PureFoods', 1, 'Hotdog', 'pack', '1', 100, 200, 10, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblreceipt`
--

CREATE TABLE `tblreceipt` (
  `receiptId` int(10) NOT NULL,
  `receiptCode` varchar(255) NOT NULL,
  `transactionId` int(10) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `paymentChange` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `dateOfTransaction` datetime NOT NULL,
  `paymentType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblroles`
--

CREATE TABLE `tblroles` (
  `id` int(255) NOT NULL,
  `roleName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblroles`
--

INSERT INTO `tblroles` (`id`, `roleName`) VALUES
(1, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `tblstockin`
--

CREATE TABLE `tblstockin` (
  `stockId` int(10) NOT NULL,
  `productId` int(10) NOT NULL,
  `supplierID` int(10) NOT NULL,
  `numberOfStockIn` int(10) NOT NULL,
  `stockInDate` datetime NOT NULL,
  `stockInExpirationDate` date NOT NULL,
  `stockToBeMinus` int(10) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstockin`
--

INSERT INTO `tblstockin` (`stockId`, `productId`, `supplierID`, `numberOfStockIn`, `stockInDate`, `stockInExpirationDate`, `stockToBeMinus`, `status`) VALUES
(1, 1, 1, 200, '2024-01-24 19:13:37', '2024-01-30', 180, ''),
(2, 1, 1, 5, '2024-01-24 19:15:23', '2024-01-31', 5, 'In Stock');

-- --------------------------------------------------------

--
-- Table structure for table `tblstockout`
--

CREATE TABLE `tblstockout` (
  `stockOutId` int(10) NOT NULL,
  `productIdentification` int(10) NOT NULL,
  `stockOutQuantity` int(10) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `stockOutDate` datetime NOT NULL,
  `deductedStockInId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblstockout`
--

INSERT INTO `tblstockout` (`stockOutId`, `productIdentification`, `stockOutQuantity`, `reason`, `stockOutDate`, `deductedStockInId`) VALUES
(1, 1, 20, 'Damaged', '2024-01-24 19:15:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsupplier`
--

CREATE TABLE `tblsupplier` (
  `supplierId` int(255) NOT NULL,
  `supplierName` varchar(255) NOT NULL,
  `phoneNumber` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `isSupplierArchived` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsupplier`
--

INSERT INTO `tblsupplier` (`supplierId`, `supplierName`, `phoneNumber`, `emailAddress`, `isSupplierArchived`) VALUES
(1, 'PureFoods', '09974391029', 'pf@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbltransactionholder`
--

CREATE TABLE `tbltransactionholder` (
  `orderId` int(10) NOT NULL,
  `productID` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `total` int(10) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `dateOfTransaction` datetime NOT NULL,
  `transactionHolderId` int(10) NOT NULL,
  `stockOutIdHolder` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbluserpermissions`
--

CREATE TABLE `tbluserpermissions` (
  `id` int(255) NOT NULL,
  `roleId` int(255) NOT NULL,
  `permission_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluserpermissions`
--

INSERT INTO `tbluserpermissions` (`id`, `roleId`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `tblinventory`
--
ALTER TABLE `tblinventory`
  ADD PRIMARY KEY (`inventoryId`);

--
-- Indexes for table `tblpermissions`
--
ALTER TABLE `tblpermissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `tblreceipt`
--
ALTER TABLE `tblreceipt`
  ADD PRIMARY KEY (`receiptId`);

--
-- Indexes for table `tblroles`
--
ALTER TABLE `tblroles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstockin`
--
ALTER TABLE `tblstockin`
  ADD PRIMARY KEY (`stockId`);

--
-- Indexes for table `tblstockout`
--
ALTER TABLE `tblstockout`
  ADD PRIMARY KEY (`stockOutId`);

--
-- Indexes for table `tblsupplier`
--
ALTER TABLE `tblsupplier`
  ADD PRIMARY KEY (`supplierId`);

--
-- Indexes for table `tbltransactionholder`
--
ALTER TABLE `tbltransactionholder`
  ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `tbluserpermissions`
--
ALTER TABLE `tbluserpermissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaccounts`
--
ALTER TABLE `tblaccounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `categoryId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblinventory`
--
ALTER TABLE `tblinventory`
  MODIFY `inventoryId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblpermissions`
--
ALTER TABLE `tblpermissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `productId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblreceipt`
--
ALTER TABLE `tblreceipt`
  MODIFY `receiptId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblroles`
--
ALTER TABLE `tblroles`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblstockin`
--
ALTER TABLE `tblstockin`
  MODIFY `stockId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblstockout`
--
ALTER TABLE `tblstockout`
  MODIFY `stockOutId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblsupplier`
--
ALTER TABLE `tblsupplier`
  MODIFY `supplierId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbltransactionholder`
--
ALTER TABLE `tbltransactionholder`
  MODIFY `orderId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbluserpermissions`
--
ALTER TABLE `tbluserpermissions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
