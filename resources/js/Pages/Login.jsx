import React from "react";
import Layout from "../Layouts/Layout";
import { Link, usePage } from "@inertiajs/react";

export default function Login() {
  const {} =
    usePage().props;

  return (
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Login</li>
                </ol>
            </div>
        </div>
    </section>






  );
}
// Attach Layout
Login.layout = (page) => <Layout title="Login">{page}</Layout>;
