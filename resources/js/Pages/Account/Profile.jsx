import React from "react";
import Layout from "../../Layouts/Layout"; // adjust path if needed
import { Link, usePage } from "@inertiajs/react";
import { route } from "ziggy-js";
import Sidebar from "./Sidebar/Sidebar";
export default function Profile() {
  const { auth } = usePage().props; // comes from Inertia shared props
  const user = auth.user;
  return (
    <Layout>
      {/* Breadcrumb Section */}
      <section className="section-5 pt-3 pb-3 mb-3 bg-white">
        <div className="container">
          <div className="light-font">
            <ol className="breadcrumb primary-color mb-0">
              <li className="breadcrumb-item">
                <a className="white-text" href="#">
                  My Account
                </a>
              </li>
              <li className="breadcrumb-item">Settings</li>
            </ol>
          </div>
        </div>
      </section>
      {/* Profile Section */}
      <section className="section-11">
        <div className="container mt-5">
          <div className="row">
            {/* Sidebar include replacement */}
            {/* You can create a <Sidebar /> component and import it here */}
            {/* Example: <Sidebar /> */}
            <Sidebar />
            <div className="col-md-9">
              <div className="card border-0 shadow-sm">
                <div className="card-header bg-primary text-white">
                  <h2 style={{ color: "black" }} className="mb-0">
                    Personal Information
                  </h2>
                </div>
                <div className="card-body p-4">
                  <div className="row justify-content-center">
                    {/* Profile Image */}
                    <div className="col-12 text-center mb-4">
                      <img
                        src={
                          user.image
                            ? `/storage/${user.image}`
                            : "/upload/user/default_user_image.png"
                        }
                        alt="Profile"
                        className="img-fluid rounded-circle border"
                        style={{
                          objectFit: "cover",
                          maxWidth: "100%",
                          height: "90%",
                          width: "30%",
                        }}
                      />
                    </div>
                    {/* User Info */}
                    <div className="col-12 mb-3">
                      <label className="form-label font-weight-bold">Name</label>
                      <div className="p-2 border rounded bg-light">{user.name}</div>
                    </div>
                    <div className="col-12 mb-3">
                      <label className="form-label font-weight-bold">Email</label>
                      <div className="p-2 border rounded bg-light">{user.email}</div>
                    </div>
                    <div className="col-12 mb-3">
                      <label className="form-label font-weight-bold">Phone</label>
                      <div className="p-2 border rounded bg-light">
                        {user.phone ?? "Not provided"}
                      </div>
                    </div>
                    <div className="col-12 mb-3">
                      <label className="form-label font-weight-bold">Address</label>
                      <div className="p-2 border rounded bg-light">
                        {user.address ?? "Not provided"}
                      </div>
                    </div>
                    {/* Edit Profile Button */}
                    <div className="col-12 text-end mt-4">
                      <Link
                        href={route("account.profileEdit")}
                        className="btn btn-primary"
                      >
                        <i className="fas fa-edit me-2"></i>Edit Profile
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </Layout>
  );
}