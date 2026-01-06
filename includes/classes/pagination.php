<?php
class Pagination {
    public $total; // Total items
    public $page; // Current page
    public $limit; // Items per page
    public $url; // URL template
    public $text; // Results text

public function render() {
    $totalPages = ceil($this->total / $this->limit);
    if ($totalPages <= 1) return '';

    $output = '<div class="pagination-default">';

    // Previous Button
    if ($this->page > 1) {
        $output .= '<a class="prev page-numbers" href="' . $this->generateUrl($this->page - 1) . '">prev</a>';
    } else {
        $output .= '<a class="prev page-numbers disabled" href="javascript:void(0);">prev</a>';
    }

    // Page Numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $this->page) {
            $output .= '<a class="page-numbers current">' . $i . '</a>';
        } else {
            $output .= '<a class="page-numbers" href="' . $this->generateUrl($i) . '">' . $i . '</a>';
        }
    }

    // Next Button
    if ($this->page < $totalPages) {
        $output .= '<a class="next page-numbers" href="' . $this->generateUrl($this->page + 1) . '">next</a>';
    } else {
        $output .= '<a class="next page-numbers disabled" href="javascript:void(0);">next</a>';
    }

    $output .= '</div>';

    // Results Text
    $start = (($this->page - 1) * $this->limit) + 1;
    $end = min($this->page * $this->limit, $this->total);
    $output .= '<div class="pag_results">' . str_replace(
        ['{start}', '{end}', '{total}', '{pages}'],
        [$start, $end, $this->total, $totalPages],
        $this->text
    ) . '</div>';

    return $output;
}


    private function generateUrl($page) {
        return str_replace('{page}', $page, $this->url);
    }
}

// Pagination Setup
$pagination = new Pagination();
$pagination->total = 11; // Total items
$pagination->page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$pagination->limit = 3; // Items per page
$pagination->url = '?page={page}';
$pagination->text = 'Showing {start} to {end} of {total} ({pages} Pages)'; // Results text

// Render the pagination HTML
$pagination_html = $pagination->render();
?>
