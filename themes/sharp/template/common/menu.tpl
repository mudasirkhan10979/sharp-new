<?php
$urlpath = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
if ($urlpath[0] == "") {
  $new_lng = 'en';
  $old_lng = 'ar';
} elseif ($urlpath[0] == "en") {
  $new_lng = 'en';
  $old_lng = 'ar';
} elseif ($urlpath[0] == "ar") {
  $new_lng = 'ar';
  $old_lng = 'en';
} else {
  $new_lng = 'en';
  $old_lng = 'ar';
}
$current_url =  str_replace("/" . $new_lng . "/", "", $_SERVER['REQUEST_URI']);
if ($old_lng == 'en') {
  $lang_url =  BASE_URL . $current_url;
} else {
  $lang_url =  BASE_URL . $old_lng . $current_url;
}
?>
<header>
  <div class="container">
    <div class="header-inn">
      <div class="row">
        <div class="col-md-2">
          <div class="site-logo">
            <a href="/">
              <img src="<?php echo $hlogo; ?>" alt="Logo">
            </a>
          </div>
        </div>
        <div class="col-md-10">
          <div class="main-menu desktop">
            <div class="main-menu-inn">
              <div class="main-nav-left">
                <?php
                // Inject dynamic "Document & Printing Solutions" section inside Business Solutions
                if (!empty($categories) && !empty($documentMenus)) {
                  foreach ($categories as &$parent) {
                    if ($parent['category_id'] == 34 && !empty($parent['children'])) {
                      $newChildren = [];
                      foreach ($parent['children'] as $child) {
                        $newChildren[] = $child;
                        if ($child['category_id'] == 9) {
                          $dynamicChildren = [];
                          foreach ($documentMenus as $menuItem) {
                            $dynamicChildren[] = array(
                              'category_id'        => $menuItem['id'],
                              // 'title'              => $menuItem['title'],
                              'short_description'  => $menuItem['title'],
                              'image'              => '',
                              'seo_url'            => $menuItem['url'],
                              'children'           => array()
                            );
                          }
                          $newChildren[] = array(
                            'category_id'        => 'doc_print_solutions',
                            'title'              => 'Document & Printing Solutions',
                            'short_description'  => 'Document & Printing Solutions',
                            'image'              => '',
                            'seo_url' => 'intelligent-print',
                            'children'           => $dynamicChildren
                          );
                        }
                      }
                      $parent['children'] = $newChildren;
                      break;
                    }
                  }
                  unset($parent);
                }
                ?>
                <ul>
                  <?php if (!empty($categories)) : ?>
                    <?php
                    if (!empty($plasmamenu)) {
                      $merged = array();
                      foreach ($categories as $p) {
                        $merged[] = $p;
                        if ($p['category_id'] == 34) {
                          $first = $plasmamenu[0];
                          $merged[] = array(
                            'category_id'        => 'plasmacluster',
                            'title'              => $first['title'],
                            'short_description'  => $first['title'],
                            'image'              => '',
                            'seo_url'            => ltrim($first['url'], '/'),
                            'children'           => array()
                          );
                        }
                      }
                      $categories = $merged;
                    }
                    ?>
                    <?php foreach ($categories as $parent) : ?>
                      <li>
                        <a href="<?php echo HTTPS_HOST . $parent['seo_url']; ?>">
                          <?php echo $parent['title']; ?>
                          <?php if (!empty($parent['children'])) : ?>
                            <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrowhead-down.svg" alt="">
                          <?php endif; ?>
                        </a>
                        <?php if (!empty($parent['children'])) : ?>
                          <div class="subnav">
                            <div class="container">
                              <div class="subnav-inn">
                                <?php foreach ($parent['children'] as $child) : ?>
                                  <?php
                                    $isDocumentMenu = ($child['category_id'] == 'doc_print_solutions');
                                    $isPlasmaMenu   = ($child['category_id'] == 'plasmacluster');

                                    if ($isDocumentMenu && !empty($child['seo_url'])) {
                                      $child_url = HTTPS_HOST . ltrim($child['seo_url'], '/');
                                    } elseif ($isPlasmaMenu && !empty($child['seo_url'])) {
                                      $child_url = HTTPS_HOST . ltrim($child['seo_url'], '/');
                                    } elseif (!empty($child['seo_url'])) {
                                      $child_url = HTTPS_HOST . rtrim($parent['seo_url'], '/') . '/' . ltrim($child['seo_url'], '/');
                                    } else {
                                      $child_url = 'javascript:void(0);';
                                    }
                                  ?>
                                  <div>
                                    <label>
                                      <a href="<?php echo $child_url; ?>"><?php echo $child['title']; ?></a>
                                    </label>

                                    <?php if (!empty($child['children'])) : ?>
                                      <ul>
                                        <?php foreach ($child['children'] as $gchild) : ?>
                                          <?php
                                          if ($isDocumentMenu && !empty($gchild['seo_url'])) {
                                            $gchild_url = HTTPS_HOST . ltrim($gchild['seo_url'], '/');
                                          } else if ($isPlasmaMenu && !empty($gchild['seo_url'])) {
                                            $gchild_url = HTTPS_HOST . ltrim($gchild['seo_url'], '/');
                                          } else if (!empty($gchild['seo_url'])) {
                                            $gchild_url = HTTPS_HOST . rtrim($parent['seo_url'], '/') . '/' . ltrim($gchild['seo_url'], '/');
                                          } else {
                                            $gchild_url = 'javascript:void(0);';
                                          }
                                          ?>
                                          <li>
                                            <a href="<?php echo $gchild_url; ?>"><?php echo $gchild['title']; ?></a>
                                          </li>
                                        <?php endforeach; ?>
                                      </ul>
                                    <?php endif; ?>
                                  </div>
                                <?php endforeach; ?>
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>
                      </li>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </div>
              <div class="main-nav-right">
                <?php if (!empty($headerMenus)) : ?>
                  <ul>
                    <?php foreach ($headerMenus as $hmenu) : ?>
                      <li><a href="<?php echo HTTPS_HOST . $hmenu['url']; ?>"><?php echo $hmenu['title']; ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
                <!--  Search Icon + Popup -->
                <span class="search" id="headerSearch">
                  <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/search.svg" alt="Search" id="searchIcon">
                  <div class="search-popup" id="searchPopup" role="dialog" aria-label="Search">
                    <div class="search-popup-inn">
                      <input type="text" placeholder="<?php echo $text_placeholder;?>" id="searchInput" aria-label="Search input">
                      <button type="button" id="closeSearch" aria-label="Close search">&times;</button>
                    </div>

                    <div id="searchResultsPopup" style="display:none; width:100%; margin-top:8px;"></div>
                  </div>
                </span>
                <?php if ($this->session->data['lang'] == 'en') { ?>
                  <span class="lang-switcher">
                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/globe_line.svg" alt=""> <a href="<?php echo $lang_url; ?>">العربية</a>
                  </span>
                <?php } else { ?>
                  <span class="lang-switcher">
                    <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/globe_line.svg" alt=""> <a href="<?php echo $lang_url; ?>">English</a>
                  </span>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="main-menu mobile">
            <div class="mobile-menu">
              <button class="hamburger">
                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/hmb-icon.svg" alt="" class="open">
                <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/close-x.svg" alt="" class="close-x">
              </button>
              <ul>
                <?php
                if (!empty($categories) && !empty($documentMenus)) {
                  foreach ($categories as &$parent) {
                    if ($parent['category_id'] == 34 && !empty($parent['children'])) {
                      $newChildren = [];
                      foreach ($parent['children'] as $child) {
                        $newChildren[] = $child;
                        if ($child['category_id'] == 9) {
                          $dynamicChildren = [];
                          foreach ($documentMenus as $menuItem) {
                            $dynamicChildren[] = array(
                              'category_id'        => $menuItem['id'],
                              // 'title'              => $menuItem['title'],
                              'short_description'  => $menuItem['title'],
                              'image'              => '',
                              'seo_url'            => $menuItem['url'],
                              'children'           => array()
                            );
                          }
                          $newChildren[] = array(
                            'category_id'        => 'doc_print_solutions',
                            'title'              => 'Document & Printing Solutions',
                            'short_description'  => 'Document & Printing Solutions',
                            'image'              => '',
                            'seo_url'            => 'intelligent-print',
                            'children'           => $dynamicChildren
                          );
                        }
                      }
                      $parent['children'] = $newChildren;
                      break;
                    }
                  }
                  unset($parent);
                }
                ?>
                <!-- Mobile Menu -->
                <?php if (!empty($categories)) : ?>
                  <?php
                  if (!empty($plasmamenu)) {
                    $merged = array();
                    foreach ($categories as $p) {
                      $merged[] = $p;
                      if ($p['category_id'] == 34) {
                        $first = $plasmamenu[0];
                        $merged[] = array(
                          'category_id'        => 'plasmacluster',
                          'title'              => $first['title'],
                          'short_description'  => $first['title'],
                          'image'              => '',
                          'seo_url'            => ltrim($first['url'], '/'),
                          'children'           => array()
                        );
                      }
                    }
                    $categories = $merged;
                  }
                  ?>
                  <?php foreach ($categories as $parent) : ?>
                    <li>
                      <a href="<?php echo HTTPS_HOST . $parent['seo_url']; ?>">
                        <?php echo $parent['title']; ?>
                        <?php if (!empty($parent['children'])) : ?>
                          <img src="<?php echo BASE_URL; ?>themes/sharp/assets/imgs/arrowhead-down.svg" alt="">
                        <?php endif; ?>
                      </a>
                      <?php if (!empty($parent['children'])) : ?>
                        <ul class="dropdown">
                          <?php foreach ($parent['children'] as $child) : ?>
                            <?php
                                $isDocumentMenu = ($child['category_id'] == 'doc_print_solutions');
                                $isPlasmaMenu   = ($child['category_id'] == 'plasmacluster');

                                if ($isDocumentMenu && !empty($child['seo_url'])) {
                                  $child_url = HTTPS_HOST . ltrim($child['seo_url'], '/');
                                } elseif ($isPlasmaMenu && !empty($child['seo_url'])) {
                                  $child_url = HTTPS_HOST . ltrim($child['seo_url'], '/');
                                } elseif (!empty($child['seo_url'])) {
                                  $child_url = HTTPS_HOST . rtrim($parent['seo_url'], '/') . '/' . ltrim($child['seo_url'], '/');
                                } else {
                                  $child_url = 'javascript:void(0);';
                                }
                            ?>
                            <li>
                              <a href="<?php echo $child_url; ?>">
                                <?php echo $child['title']; ?>
                              </a>
                              <?php if (!empty($child['children'])) : ?>
                                <ul>
                                  <?php foreach ($child['children'] as $gchild) : ?>
                                    <?php
                                    if ($isDocumentMenu && !empty($gchild['seo_url'])) {
                                      $gchild_url = HTTPS_HOST . ltrim($gchild['seo_url'], '/');
                                    } else if ($isPlasmaMenu && !empty($gchild['seo_url'])) {
                                      $gchild_url = HTTPS_HOST . ltrim($gchild['seo_url'], '/');
                                    } else if (!empty($gchild['seo_url'])) {
                                      $gchild_url = HTTPS_HOST . rtrim($parent['seo_url'], '/') . '/' . ltrim($gchild['seo_url'], '/');
                                    } else {
                                      $gchild_url = 'javascript:void(0);';
                                    }
                                    ?>
                                    <li>
                                      <a href="<?php echo $gchild_url; ?>">
                                        <?php echo $gchild['title']; ?>
                                      </a>
                                    </li>
                                  <?php endforeach; ?>
                                </ul>
                              <?php endif; ?>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                <?php endif; ?>
                <?php if (!empty($headerMenus)) : ?>
                  <?php foreach ($headerMenus as $hmenu) : ?>
                    <li><a href="<?php echo HTTPS_HOST . $hmenu['url']; ?>"><?php echo $hmenu['title']; ?></a></li>
                  <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<style>
  #searchResultsPopup {
    max-height: 150px;
    overflow-y: scroll;
    border-top: 1px solid #00000030;
  }

  /* ===== SEARCH POPUP ===== */
  .search {
    position: relative;
    display: inline-block;
  }

  .search img {
    cursor: pointer;
    width: 24px;
    height: 24px;
    transition: transform 0.2s ease;
  }

  .search img:hover {
    transform: scale(1.1);
  }

  .search-popup {
    display: none;
    position: absolute;
    top: 35px;
    right: 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 30px;
    padding: 8px 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    z-index: 999;
    width: 320px;
  }

  .search-popup input {
    border: none;
    outline: none;
    font-size: 14px;
    padding: 5px 10px;
    flex: 0 0 87%;
    height: 40px;
  }

  .search-popup.show .search-popup-inn button#closeSearch {
    flex: 0 0 10%;
  }

  .search-popup button {
    background: transparent;
    border: none;
    font-size: 25px;
    cursor: pointer;
    color: #555;
  }

  button#closeSearch:hover,
  #searchResultsPopup a.popup-item:hover {
    color: #E6000D !important;
  }

  .search-popup.show {
    display: block !important;
    align-items: center;
    animation: fadeIn 0.25s ease;
  }

  .search-popup.show .search-popup-inn {
    display: flex;
    gap: 7px;
    /* border-bottom: 1px solid #00000030; */
  }


  #searchResultsPopup::-webkit-scrollbar {
    width: 10px;
  }

  #searchResultsPopup::-webkit-scrollbar-track {
    background: transparent;
  }

  #searchResultsPopup::-webkit-scrollbar-thumb {
    background: #888;
  }

  #searchResultsPopup::-webkit-scrollbar-thumb:hover {
    background: #555;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-5px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<script>
  (function() {
    const searchIcon = document.getElementById("searchIcon");
    const searchPopup = document.getElementById("searchPopup");
    const closeSearch = document.getElementById("closeSearch");
    const searchInput = document.getElementById("searchInput");
    const resultsContainer = document.getElementById("searchResultsPopup");

    function clearResults() {
      resultsContainer.innerHTML = '';
      resultsContainer.style.display = 'none';
    }

    // Toggle popup
    searchIcon.addEventListener("click", (e) => {
      e.stopPropagation();
      const isOpen = searchPopup.classList.toggle("show");

      if (isOpen) {
        searchInput.value = "";
        clearResults();
        searchInput.focus();
      } else {
        clearResults();
      }
    });

    // Close popup
    closeSearch.addEventListener("click", () => {
      searchPopup.classList.remove("show");
      searchInput.value = "";
      clearResults();
    });

    // Click outside closes
    document.addEventListener("click", (e) => {
      if (!searchPopup.contains(e.target) && e.target !== searchIcon) {
        searchPopup.classList.remove("show");
        searchInput.value = "";
        clearResults();
      }
    });
    // Debounce helper
    function debounce(fn, delay) {
      let t;
      return function(...args) {
        clearTimeout(t);
        t = setTimeout(() => fn.apply(this, args), delay);
      };
    }

    // Escape HTML
    function escapeHtml(unsafe) {
      return unsafe.replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }

    // Render search results
    function renderResults(json) {
      if (!json || !json.products || json.products.length === 0) {
        resultsContainer.innerHTML = '<div class="no-results-popup">No result found</div>';
        resultsContainer.style.display = 'block';
        return;
      }
      const html = json.products.map(p => {
        const name = escapeHtml(p.name);
        const url = p.url;
        const img = p.image;
        const price = p.price || '';
        return `<a class="popup-item" href="${url}" style="display:flex;gap:8px;align-items:center;padding:6px 0;text-decoration:none;color:inherit;">
                <img src="${img}" alt="${name}" width="48" height="48" loading="lazy" style="object-fit:cover;border-radius:4px;">
                <div style="flex:1">
                  <div style="font-size:13px;">${name}</div>
                  <div style="font-size:12px;color:#666">${price}</div>
                </div>
              </a>`;
      }).join('');
      resultsContainer.innerHTML = html;
      resultsContainer.style.display = 'block';
    }

    // Fetch results
    async function fetchPopup(term) {
      if (!term || term.length < 2) {
        clearResults();
        return;
      }
      const params = new URLSearchParams({
        term: term,
        page: 1
      });
      try {
        const res = await fetch('<?php echo HTTPS_HOST; ?>search/ajax?' + params.toString(), {
          credentials: 'same-origin'
        });
        if (!res.ok) throw new Error('Network error');
        const json = await res.json();
        if (json && json.success) renderResults(json);
        else clearResults();
      } catch (e) {
        clearResults();
        console.error('Search popup error', e);
      }
    }

    const debouncedFetch = debounce((val) => fetchPopup(val), 250);

    // Input typing
    searchInput.addEventListener('input', (e) => {
      const v = e.target.value.trim();
      debouncedFetch(v);
    });
    // Pressing Enter redirects
    searchInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        const q = searchInput.value.trim();
        if (q.length) {
          window.location.href = '<?php echo HTTPS_HOST; ?>search?keywords=' + encodeURIComponent(q);
        }
      }
    });
  })();
</script>
