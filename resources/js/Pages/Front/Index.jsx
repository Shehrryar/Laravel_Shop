import React, { useEffect, useState } from 'react';

export default function HomePage() {
  const [loading, setLoading] = useState(true);
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [darkMode, setDarkMode] = useState(false);
  const [rtl, setRtl] = useState(false);

  useEffect(() => {
    // simulate loader finishing
    const t = setTimeout(() => setLoading(false), 600);
    return () => clearTimeout(t);
  }, []);

  useEffect(() => {
    // apply dark mode class on document body
    if (darkMode) document.body.classList.add('dark-mode');
    else document.body.classList.remove('dark-mode');
  }, [darkMode]);

  useEffect(() => {
    // apply RTL on html dir attribute
    document.documentElement.dir = rtl ? 'rtl' : 'ltr';
  }, [rtl]);

  // small helper to toggle sidebar
  function toggleSidebar() {
    
    setSidebarOpen(prev => !prev);
  }

  return (
    <>
      {/* loader start */}
      {loading && (
        <div className="loader">
          <span />
          <span />
        </div>
      )}
      {/* loader end */}

      {/* header start */}
      <header>
        <div className="nav-bar" onClick={toggleSidebar}>
          <img src="front-assets/svg/bar.svg" className="img-fluid" alt="menu" />
        </div>

        <a href="index.html" className="brand-logo">
          <img src="front-assets/images/logo.png" className="img-fluid main-logo" alt="logo" />
          <img src="front-assets/images/logo-white.png" className="img-fluid white-logo" alt="logo white" />
        </a>

        <div className="header-option">
          <ul>
            <li>
              <a href="search.html"><i className="iconly-Search icli" /></a>
            </li>
            <li>
              <a href="notification.html"><i className="iconly-Notification icli" /></a>
            </li>
            <li>
              <a href="wishlist.html"><i className="iconly-Heart icli" /></a>
            </li>
            <li>
              <a href="cart.html"><i className="iconly-Buy icli" /></a>
            </li>
          </ul>
        </div>
      </header>

      <a
        href="#"
        className={`overlay-sidebar ${sidebarOpen ? 'open' : ''}`}
        onClick={() => setSidebarOpen(false)}
      />

      <div className={`header-sidebar ${sidebarOpen ? 'open' : ''}`}>
        <a href="profile-setting.html" className="user-panel">
          <img src="front-assets/images/user/1.png" className="img-fluid user-img" alt="user" />
          <span>Hello, Paige Turner</span>
          <i className="iconly-Arrow-Right-2 icli" />
        </a>
        <div className="sidebar-content">
          <ul className="link-section">
            <li>
              <div>
                <i className="iconly-Setting icli" />
                <div className="content toggle-sec w-100">
                  <div>
                    <h4 className="mb-0">Dark Mode</h4>
                  </div>
                  <div className="button toggle-btn ms-auto">
                    <input
                      id="darkButton"
                      type="checkbox"
                      className="checkbox"
                      checked={darkMode}
                      onChange={e => setDarkMode(e.target.checked)}
                    />
                    <div className="knobs">
                      <span />
                    </div>
                    <div className="layer" />
                  </div>
                </div>
              </div>
            </li>

            <li>
              <div>
                <i className="iconly-Setting icli" />
                <div className="content toggle-sec w-100">
                  <div>
                    <h4 className="mb-0">RTL</h4>
                  </div>
                  <div className="button toggle-btn ms-auto">
                    <input
                      id="rtlButton"
                      type="checkbox"
                      className="checkbox"
                      checked={rtl}
                      onChange={e => setRtl(e.target.checked)}
                    />
                    <div className="knobs">
                      <span />
                    </div>
                    <div className="layer" />
                  </div>
                </div>
              </div>
            </li>

            <li>
              <a href="pages.html">
                <i className="iconly-Paper icli" />
                <div className="content">
                  <h4>Pages</h4>
                  <h6>Elements & Other Pages</h6>
                </div>
              </a>
            </li>

            <li>
              <a href="index.html">
                <i className="iconly-Home icli" />
                <div className="content">
                  <h4>Home</h4>
                  <h6>Offers, Top Deals, Top Brands</h6>
                </div>
              </a>
            </li>

            <li>
              <a href="category.html">
                <i className="iconly-Category icli" />
                <div className="content">
                  <h4>Shop by Category</h4>
                  <h6>Men, Women, Kids, Beauty.. </h6>
                </div>
              </a>
            </li>

            <li>
              <a href="order-history.html">
                <i className="iconly-Document icli" />
                <div className="content">
                  <h4>Orders</h4>
                  <h6>Ongoing Orders, Recent Orders..</h6>
                </div>
              </a>
            </li>

            <li>
              <a href="wishlist.html">
                <i className="iconly-Heart icli" />
                <div className="content">
                  <h4>Your Wishlist</h4>
                  <h6>Your Save Products</h6>
                </div>
              </a>
            </li>

            <li>
              <a href="profile.html">
                <i className="iconly-Profile icli" />
                <div className="content">
                  <h4>Your Account</h4>
                  <h6>Profile, Settings, Saved Cards...</h6>
                </div>
              </a>
            </li>

            <li>
              <a href="#">
                <img src="front-assets/images/flag.png" className="img-fluid" alt="flag" />
                <div className="content">
                  <h4>Langauge</h4>
                  <h6>Select your Language here..</h6>
                </div>
              </a>
            </li>

            <li>
              <a href="notification.html">
                <i className="iconly-Notification icli" />
                <div className="content">
                  <h4>Notification</h4>
                  <h6>Offers, Order tracking messages..</h6>
                </div>
              </a>
            </li>

            <li>
              <a href="settings.html">
                <i className="iconly-Setting icli" />
                <div className="content">
                  <h4>Settings</h4>
                  <h6>Dark mode, RTL, Notification</h6>
                </div>
              </a>
            </li>
          </ul>

          <div className="divider" />

          <ul className="link-section">
            <li>
              <a href="about-us.html">
                <i className="iconly-Info-Square icli" />
                <div className="content">
                  <h4>About us</h4>
                  <h6>About Multikart</h6>
                </div>
              </a>
            </li>
            <li>
              <a href="help.html">
                <i className="iconly-Call icli" />
                <div className="content">
                  <h4>Help/Customer Care</h4>
                  <h6>Customer Support, FAQs</h6>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
      {/* header end */}

      {/* category start */}
      <section className="category-section top-space">
        <ul className="category-slide">
          <li>
            <a href="inner-category.html" className="category-box">
              <img src="front-assets/images/top-category/kids.png" className="img-fluid" alt="kids" />
              <h4>Kids</h4>
            </a>
          </li>
        </ul>
      </section>
      <div className="divider t-12 b-20" />
      {/* category end */}

      {/* home slider start */}
      <section className="pt-0 home-section ratio_55">
        <div className="home-slider slick-default theme-dots">
          <div>
            <div className="slider-box">
              <img src="front-assets/images/home-slider/1.jpg" className="img-fluid bg-img" alt="slide" />
              <div className="slider-content">
                <div>
                  <h2>Welcome To Multikart</h2>
                  <h1>Flat 50% OFF</h1>
                  <h6>Free Shipping Till Mid Night</h6>
                  <a href="shop.html" className="btn btn-solid">SHOP NOW</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      {/* home slider end */}

      {/* deals section start */}
      <section className="deals-section px-15 pt-0">
        <div className="title-part">
          <h2>Deals of the Day</h2>
          <a href="shop.html">See All</a>
        </div>
        <div className="product-section">
          <div className="row gy-3">
            {[1, 2, 3].map(i => (
              <div className="col-12" key={i}>
                <div className="product-inline">
                  <a href="product.html">
                    <img src={`front-assets/images/products/${i}.jpg`} className="img-fluid" alt={`prod-${i}`} />
                  </a>
                  <div className="product-inline-content">
                    <div>
                      <a href="product.html">
                        <h4>{i === 2 ? 'Men Blue Denim Jacket' : 'Pink Hoodie t-shirt full'}</h4>
                      </a>
                      <h5>{i === 2 ? 'by Zara' : i === 1 ? 'by Mango' : 'by H&M'}</h5>
                      <div className="price">
                        <h4>$32.00 {i !== 2 && <del>$35.00</del>}<span>20%</span></h4>
                      </div>
                    </div>
                  </div>
                  <div className="wishlist-btn">
                    <i className="iconly-Heart icli" />
                    <i className="iconly-Heart icbo" />
                    <div className="effect-group">
                      <span className="effect" />
                      <span className="effect" />
                      <span className="effect" />
                      <span className="effect" />
                      <span className="effect" />
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
      <div className="divider" />
      {/* deals section end */}

      {/* tab section start */}
      <section className="pt-0 tab-section">
        <div className="title-section px-15">
          <h2>Find your Style</h2>
          <h3>Super Summer Sale</h3>
        </div>

        <div className="tab-section">
          <ul className="nav nav-tabs theme-tab pl-15">
            <li className="nav-item">
              <button className="nav-link active" type="button">Trending Now</button>
            </li>
            <li className="nav-item">
              <button className="nav-link" type="button">Top Picks</button>
            </li>
            <li className="nav-item">
              <button className="nav-link" type="button">Featured Products</button>
            </li>
            <li className="nav-item">
              <button className="nav-link" type="button">Top Rated</button>
            </li>
            <li className="nav-item">
              <button className="nav-link" type="button">Ready to ship</button>
            </li>
          </ul>

          <div className="tab-content px-15">
            <div className="tab-pane fade show active" id="trending">
              <div className="row gy-3 gx-3">
                <div className="col-md-4 col-6">
                  <div className="product-box ratio_square">
                    <div className="img-part">
                      <a href="product.html"><img src="front-assets/images/products/4.jpg" alt="" className="img-fluid bg-img" /></a>
                      <div className="wishlist-btn">
                        <i className="iconly-Heart icli" />
                        <i className="iconly-Heart icbo" />
                        <div className="effect-group">
                          <span className="effect" />
                          <span className="effect" />
                          <span className="effect" />
                          <span className="effect" />
                          <span className="effect" />
                        </div>
                      </div>
                    </div>
                    <div className="product-content">
                      <ul className="ratings">
                        <li><i className="iconly-Star icbo" /></li>
                        <li><i className="iconly-Star icbo" /></li>
                        <li><i className="iconly-Star icbo" /></li>
                        <li><i className="iconly-Star icbo" /></li>
                        <li><i className="iconly-Star icbo empty" /></li>
                      </ul>
                      <a href="product.html"><h4>Blue Denim Jacket</h4></a>
                      <div className="price"><h4>$32.00 <del>$35.00</del><span>20%</span></h4></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* other tab panes can be built similarly - keeping structure concise */}

          </div>
        </div>
      </section>
      {/* tab section end */}

      {/* timer banner start */}
      <section className="banner-timer">
        <div className="banner-bg">
          <div className="banner-content">
            <div>
              <h6>Denim Wear</h6>
              <h2>Sales Starts In</h2>
              <div className="counters">
                <div className="counter d-none">
                  <span id="days">NA</span>
                  <p>Days</p>
                </div>
                <div className="counter">
                  <span id="hours">NA</span>
                  <p>Hours</p>
                </div>
                <div className="counter">
                  <span id="minutes">NA</span>
                  <p>Minutes</p>
                </div>
                <div className="counter">
                  <span id="seconds">NA</span>
                  <p>Seconds</p>
                </div>
              </div>
              <a href="shop.html">explore now</a>
            </div>
          </div>
          <div className="banner-img">
            <img src="front-assets/images/banner-image.png" className="img-fluid" alt="banner" />
          </div>
        </div>
      </section>
      {/* timer banner end */}

      {/* brands section start */}
      <section className="brand-section pl-15">
        <h2 className="title">Biggest Deals on Top Brands</h2>
        <div className="brand-slider slick-default">
          {[1,2,3,4,5].map(i => (
            <div key={i}>
              <a className="brand-box" href="shop.html">
                <img src={`assets/images/brand-logos/${i}.png`} className="img-fluid" alt={`brand-${i}`} />
              </a>
            </div>
          ))}
        </div>
      </section>
      <div className="divider" />
      {/* brands section end */}

      {/* kids corner section start */}
      <section className="pt-0 product-slider-section overflow-hidden">
        <div className="title-section px-15">
          <h2>The Kids Corner</h2>
          <h3>Clothing for your Li’l One’s </h3>
        </div>
        <div className="product-slider slick-default pl-15">
          {[9,10,8].map(i => (
            <div key={i}>
              <div className="product-box ratio_square">
                <div className="img-part">
                  <a href="product.html"><img src={`assets/images/products/${i}.jpg`} alt="" className="img-fluid bg-img" /></a>
                  <div className="wishlist-btn">
                    <i className="iconly-Heart icli" />
                    <i className="iconly-Heart icbo" />
                    <div className="effect-group">
                      <span className="effect" />
                      <span className="effect" />
                      <span className="effect" />
                      <span className="effect" />
                      <span className="effect" />
                    </div>
                  </div>
                </div>
                <div className="product-content">
                  <ul className="ratings">
                    <li><i className="iconly-Star icbo" /></li>
                    <li><i className="iconly-Star icbo" /></li>
                    <li><i className="iconly-Star icbo" /></li>
                    <li><i className="iconly-Star icbo" /></li>
                    <li><i className="iconly-Star icbo empty" /></li>
                  </ul>
                  <a href="product.html"><h4>Blue Denim Jacket</h4></a>
                  <div className="price"><h4>$32.00 <del>$35.00</del><span>20%</span></h4></div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </section>
      {/* kids corner section end */}

      {/* offer corner start */}
      <section className="offer-corner-section px-15">
        <h2 className="title">Offer Corner</h2>
        <div className="row g-3">
          {['Under $50.00','Flat $20 OFF','buy 1 get 1','upto 50% off'].map((t, idx) => (
            <div className="col-6" key={idx}>
              <div className="offer-box"><a href="shop.html">{t}</a></div>
            </div>
          ))}
        </div>
      </section>
      {/* offer corner end */}

      <section className="panel-space" />

      {/* bottom panel start */}
      <div className="bottom-panel">
        <ul>
          {[{href:'index.html',label:'home',icon:'Home'},{href:'category.html',label:'category',icon:'Category'},{href:'cart.html',label:'cart',icon:'Buy'},{href:'wishlist.html',label:'wishlist',icon:'Heart'},{href:'profile.html',label:'profile',icon:'Profile'}].map((it, idx) => (
            <li className={idx === 0 ? 'active' : ''} key={it.label}>
              <a href={it.href}>
                <div className="icon">
                  <i className={`iconly-${it.icon} icli`} />
                  <i className={`iconly-${it.icon} icbo`} />
                </div>
                <span>{it.label}</span>
              </a>
            </li>
          ))}
        </ul>
      </div>
      {/* bottom panel end */}
    </>
  );
}
