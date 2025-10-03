import React from "react";
import Layout from "../Layouts/Layout";
import { Link, usePage, router} from "@inertiajs/react";
import { route } from "ziggy-js";

export default function Cart() {
  const { cartcount, cartcontent, discount } = usePage().props;
  const updateCart = (rowId, qty) => {


    // Inertia.post(route("front.updateCart"), { rowid: rowId, qty: qty });
  };
const deleteItem = (rowId) => {
  if (confirm("Are you sure you want to delete?")) {
    router.post(route("front.deleteitem.cart"),{ rowid: rowId }, // data you are passing
      {
        onError: (err) => {
          console.error("Delete failed:", err);
        },
        onSuccess: () => {
          console.log("Item deleted successfully!");
        },
      }
    );
  }
};
  const getDiscountedPrice = (productId, discounts, price) => {
    const activeDiscount = discounts.find((d) => d.product_id === productId);
    if (activeDiscount) {
      const discountValue = activeDiscount.value; // assume % value from DB
      const finalPrice = price - (price * discountValue) / 100;
      return { discount_value: discountValue, finalPrice };
    }
    return { discount_value: 0, finalPrice: price };
  };
  if (cartcount === 0) {
    return (
      <section className="section-9 pt-4">
        <div className="container">
          <h1>Cart is empty</h1>
        </div>
      </section>
    );
  }
  return (
    <section className="section-9 pt-4">
      <div className="container">
        <div className="row">
          <div className="col-md-8">
            <div className="table-responsive">
              <table className="table" id="cart">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                  </tr>
                </thead>
                <tbody>
                  {cartcontent.map((item) => {
                    const { discount_value } = getDiscountedPrice(
                      item.product_id,
                      discount,
                      item.price
                    );
                    return (
                      <tr key={item.id}>
                        <td>
                          <div className="d-flex align-items-center">
                            <img
                              src={
                                item.product_image
                                  ? `/upload/products/${item.product_image}`
                                  : "/admin-assets/img/default-150x150.png"
                              }
                              className="img-thumbnail"
                              style={{
                                width: "50px",
                                height: "50px",
                                marginRight: "10px",
                              }}
                              alt={item.title}
                            />
                            <div>
                              <h2 className="h5 mb-0">{item.title}</h2>
                              {item.size_id && (
                                <span className="badge bg-secondary ms-2">
                                  Size {item.size_id}
                                </span>
                              )}
                              {item.color_id && (
                                <span className="badge bg-info text-dark ms-2">
                                  Color {item.color_id}
                                </span>
                              )}
                            </div>
                          </div>
                        </td>
                        <td>{item.price}</td>
                        <td>{discount_value ? `${discount_value}%` : "0%"}</td>
                        <td>
                          <div
                            className="input-group quantity mx-auto"
                            style={{ width: "100px" }}
                          >
                            <button
                              className="btn btn-sm btn-dark p-2 pt-1 pb-1"
                              onClick={() =>
                                item.quantity > 1 &&
                                updateCart(item.id, item.quantity - 1)
                              }
                            >
                              <i className="fa fa-minus"></i>
                            </button>
                            <input
                              type="text"
                              className="form-control form-control-sm border-0 text-center"
                              value={item.quantity}
                              readOnly
                            />
                            <button
                              className="btn btn-sm btn-dark p-2 pt-1 pb-1"
                              onClick={() =>
                                item.quantity < 25 &&
                                updateCart(item.id, item.quantity + 1)
                              }
                            >
                              <i className="fa fa-plus"></i>
                            </button>
                          </div>
                        </td>
                        <td>{item.price * item.quantity}</td>
                        <td>
                          <button
                            className="btn btn-sm btn-danger"
                            onClick={() => deleteItem(item.id)}
                          >
                            <i className="fa fa-times"></i>
                          </button>
                        </td>
                      </tr>
                    );
                  })}
                </tbody>
              </table>
            </div>
          </div>
          {/* ✅ Cart Summary */}
          <div className="col-md-4">
            <div className="card cart-summery">
              <div className="card-body">
                <div className="sub-title">
                  <h2 className="bg-white">Cart Summary</h2>
                </div>
                <div className="d-flex justify-content-between pb-2">
                  <div>Subtotal</div>
                  <div>
                    {cartcontent.reduce(
                      (acc, item) => acc + item.price * item.quantity,
                      0
                    )}
                  </div>
                </div>
                <div className="pt-5">
                  <a
                    href={route("front.checkout")}
                    className="btn-dark btn btn-block w-100"
                  >
                    Proceed to Checkout
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
Cart.layout = (page) => <Layout title="Cart">{page}</Layout>;