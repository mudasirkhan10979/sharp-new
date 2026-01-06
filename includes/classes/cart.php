<?php
class Cart
{
	private $data = array();
	private $memberId = "";


	public function __construct($registry)
	{
		$this->config = $registry->get('config');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		$this->memberId = $this->session->data['member_id'];

		// Remove all the expired carts with no customer ID
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE (member_id = '0') AND date_added < DATE_SUB(NOW(), INTERVAL 1 HOUR)");

		if ($this->memberId) {
			// We want to change the session ID on all the old items in the customers cart
			$this->db->query("UPDATE " . DB_PREFIX . "cart SET session_id = '" . $this->db->escape($this->session->getId()) . "' WHERE member_id = '" . (int)$this->memberId . "'");

			// Once the customer is logged in we want to update the customers cart
			$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE member_id = '0' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

			foreach ($cart_query->rows as $cart) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart['cart_id'] . "'");

				// The advantage of using $this->add is that it will check if the products already exist and increaser the quantity if necessary.
				$this->add($cart['program_id'], $cart['quantity']);
			}
		}
	}

	public function add($programId, $quantity = 1)
	{
		// exit('here');
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cart WHERE  member_id = '" . (int)$this->memberId . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND program_id = '" . (int)$programId . "'");

		if (!$query->row['total']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "cart SET member_id = '" . (int)$this->memberId . "', session_id = '" . $this->db->escape($this->session->getId()) . "', program_id = '" . (int)$programId . "', quantity = '" . (int)$quantity . "', date_added = NOW()");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = (quantity + " . (int)$quantity . ") WHERE  member_id = '" . (int)$this->memberId . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND program_id = '" . (int)$programId . "'");
		}
	}
	public function getPrograms()
	{

		$program_options = array();

		$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE member_id = '" . (int)$this->memberId . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

		foreach ($cart_query->rows as $cart) {
			$program = $this->getProgramById($cart['program_id']);
			$stock = $this->getProgramsStock($cart['program_id']);
			$cart_collection_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart_collection_points WHERE member_id = '" . (int)$this->memberId . "' AND cart_id = '" . (int)$cart['cart_id'] . "'");
			if ($program) {
				$image = DIR_IMAGE_PATH . "ptprogram/" . $program['image'];
				if ($cart_collection_query->rows) {
					$program_options = $cart_collection_query->rows;
				} else {
					$program_options = array();
				}
				for ($i = 0; $i < $cart['quantity']; $i++) {
					$currentDate = date('Y-m-d');
					$currentDate = date('Y-m-d', strtotime($currentDate));
					$closingDate = strtotime($program['closing_date']);

					if ($currentDate > $closingDate || $program['stock'] >= 40) {
						$outOfStock = 'Closed';
					} else {
						$outOfStock = '';
					}

					$program_data[] = array(
						'cart_id'     => $cart['cart_id'],
						'program_id'  => $program['program_id'],
						'name'        => $program['title'],
						'price'       => $program['price'],
						'options'     => ($program_options[$i]) ?? [],
						'quantity'    => $cart['quantity'],
						'stock'       => $stock['stock'],
						'closing_date' => $stock['closing_date'],
						'image'       => $image,
						'stockStatus' => $outOfStock,
						'href'        => HTTPS_HOST . $program['pt_url']
					);
				}
			} else {
				$this->remove($cart['cart_id']);
			}
		}

		return $program_data;
	}
	public function getProgramsStock($program_id)
	{

		$cart_query = $this->db->query("SELECT (SELECT SUM(quantity) FROM booking WHERE program_id = '" . (int)$program_id . "') AS stock,closing_date FROM ptprograms WHERE program_id = '" . (int)$program_id . "'");
		return $cart_query->row;
	}
	public function getCartPrograms()
	{
		$program_data = array();

		$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE member_id = '" . (int)$this->memberId . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

		foreach ($cart_query->rows as $cart) {
			$program = $this->getProgramById($cart['program_id']);

			$cart_collection_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart_collection_points WHERE member_id = '" . (int)$this->memberId . "' AND cart_id = '" . (int)$cart['cart_id'] . "'");

			if ($program) {
				$image = DIR_IMAGE_PATH . "ptprogram/" . $program['image'];

				$collectionIds = array_column($cart_collection_query->rows, 'collection_point_id');
				$program_options  = implode(',', $collectionIds);
				// echo "<pre>";print_r($program_options);exit;

				$program_data[] = array(
					'cart_id'     => $cart['cart_id'],
					'program_id'  => $program['program_id'],
					'name'        => $program['title'],
					'price'       => $program['price'],
					'options'     => $program_options,
					'quantity'    => $cart['quantity'],
					'image'       => $image
				);
			} else {
				$this->remove($cart['cart_id']);
			}
		}

		return $program_data;
	}

	public function update($cart_id, $quantity, $option)
	{
		// Update the quantity
		$cart_id = (int)$cart_id;
		$quantity = (int)$quantity;
		$session_id = $this->db->escape($this->session->getId());

		$update_query = "
        UPDATE " . DB_PREFIX . "cart
        SET quantity = '$quantity'
        WHERE cart_id = '$cart_id'
        AND member_id = '" . (int)$this->memberId . "'
        AND session_id = '$session_id'
    ";
		$this->db->query($update_query);

		// Handle collection points
		$collectionPoints = $option;

		if ($collectionPoints) {
			$cart_id = (int)$cart_id;
			$this->db->query("DELETE FROM " . DB_PREFIX . "cart_collection_points WHERE cart_id = '$cart_id'");

			foreach ($collectionPoints as $collection_point_id) {
				$collection_point_id = (int)$collection_point_id;
				if ($collection_point_id > 0) {
					$this->db->query("
					INSERT INTO " . DB_PREFIX . "cart_collection_points
					SET cart_id = '$cart_id',
					collection_point_id = '$collection_point_id',
					member_id = '" . (int)$this->memberId . "'
				");
				}
			}
		}

		// Check if the quantity becomes zero
		if ($quantity <= 0) {
			// Delete the entry from the cart table
			$this->remove($cart_id);
		}
	}
	public function getProgramCountById($programId)
	{
		$program_count = 0;

		$cart_query = $this->db->query("SELECT SUM(quantity) AS total FROM " . DB_PREFIX . "cart WHERE member_id = '" . (int)$this->memberId . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND program_id = '" . (int)$programId . "'");

		if ($cart_query->num_rows) {
			$program_count = (int)$cart_query->row['total'];
		}

		return $program_count;
	}

	public function updateProgramQuantity($cart_id, $quantity, $collection_point_id = '')
	{
		// Update the quantity
		$this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = '" . (int)$quantity . "' WHERE cart_id = '" . (int)$cart_id . "' AND member_id = '" . (int)$this->memberId . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

		if ($collection_point_id) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "cart_collection_points WHERE cart_id = '" . (int)$cart_id . "' AND member_id = '" . (int)$this->memberId . "' AND collection_point_id = '" . $collection_point_id . "'");
		}
		// Check if the quantity becomes zero
		if ($quantity <= 0) {
			// Delete the entry from the cart table
			$this->remove($cart_id);
		}
	}
	public function remove($cart_id)
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart_collection_points WHERE cart_id = '" . (int)$cart_id . "' AND member_id = '" . (int)$this->memberId . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart_id . "' AND member_id = '" . (int)$this->memberId . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function clear()
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE member_id = '" . (int)$this->memberId . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart_collection_points WHERE  member_id = '" . (int)$this->memberId . "'");
	}

	private function getProgramById($programId)
	{
		$sql = "SELECT pt.*, 
                    category.title as category_title,
                    a.url as pt_url
                    FROM ptprograms pt 
                    INNER JOIN category ON pt.category_id = category.category_id 
                    LEFT JOIN aliases a ON a.slog_id = pt.program_id AND a.slog = 'ptprograms' 
                    WHERE pt.program_id = '" . $programId . "'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getTotal()
	{
		$total = 0;

		foreach ($this->getCartPrograms() as $program) {
			$total += $program['price'] * $program['quantity'];
		}

		return $total;
	}

	public function countPrograms()
	{
		$program_total = 0;

		$programs = $this->getCartPrograms();

		foreach ($programs as $program) {
			$program_total += $program['quantity'];
		}

		return $program_total;
	}
	public function countCollectionPoints()
	{
		$count = $this->db->query("SELECT COUNT(*) as count FROM " . DB_PREFIX . "cart_collection_points WHERE member_id = '" . (int)$this->memberId . "'");

		return $count->row['count'];
	}

	public function hasPrograms()
	{
		return count($this->getCartPrograms());
	}

	public function hasStock()
	{

		foreach ($this->getPrograms() as $program) {
			$currentDate = date('Y-m-d');
			$currentDate = date('Y-m-d', strtotime($currentDate));
			$closingDate = strtotime($program['closing_date']);
			if ($program['stock'] >= 40 || $closingDate < $currentDate) {
				return false;
			}
		}
		return true;
	}
}
