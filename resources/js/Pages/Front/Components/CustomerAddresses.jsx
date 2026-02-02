import React, { useState } from "react";
import { Link } from "@inertiajs/react";
import { route } from "ziggy-js";
import axios from "axios";

// resources/js/Components/Front/CustomerAddresses.jsx
export default function CustomerAddresses({ customerAddresses = [] }) {
    const handleRemove = async (id) => {
        try {
            const response = await axios.post(route("account.removeAddress"), {
                id: id,
            });
            if (response.data.status) {
                setMessage({ text: response.data.message, type: "success" });
                //  Refresh only addresses
                router.reload({ only: ["customerAddress"] });
            } else {
                setMessage({ text: response.data.message, type: "error" });
            }
        } catch (error) {
            console.error(error);
            setMessage({
                text: "Something went wrong while removing address.",
                type: "error",
            });
        }
        // Hide message after 3 seconds
        setTimeout(() => setMessage({ text: "", type: "" }), 3000);
    };

    return (
        <section className="top-space px-15">
            <div className="delivery-option-section">
                <ul>
                    {customerAddresses.map((address, index) => (
                        <li key={index}>
                            <div className="check-box active">
                                <div className="form-check d-flex ps-0">
                                    <input
                                        className="radio_animated"
                                        type="radio"
                                        name="flexRadioDefault"
                                        id={`flexRadioDefault${index}`}
                                        checked={address.is_default === 1}
                                        readOnly
                                    />

                                    <label
                                        className="form-check-label"
                                        htmlFor={`flexRadioDefault${index}`}
                                    ></label>
                                    <div>
                                        <h4 className="name">
                                            {address.translated_firstname}
                                            {address.translated_lastname}
                                        </h4>
                                        <div className="addess">
                                            <h4>{address.translated_address}</h4>
                                            <h4>
                                                {address.translated_city}, {address.translated_state}
                                            </h4>
                                            <h4>{address.zip}</h4>
                                        </div>
                                        <h4>Phone No: {address.mobile}</h4>
                                        <h6 className="label text-uppercase">
                                            {address.address_type || "HOME"}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div className="buttons">
                                <Link
                                    as="button"
                                    type="button"
                                    onClick={() => handleRemove(address.id)}
                                    className="me-2 text-danger"
                                >
                                    Remove
                                </Link>

                                <Link
                                    href={route(
                                        "account.EditAddress",
                                        address.id
                                    )}
                                    className="text-primary"
                                >
                                    Edit
                                </Link>
                            </div>
                        </li>
                    ))}
                </ul>
                <Link
                    href={route("account.newAddress")}
                    className="btn btn-outline text-capitalize w-100 mt-3"
                >
                    Add New Address
                </Link>
            </div>
        </section>
    );
}
