import React from "react";
import ReactDOM from "react";

export default function HelloReact() {

    return (
        <h1>Hello React!</h1>
    );

}

if (document.getElementById('hello-react')) {
    ReactDOM.render(<HelloReact />, document.getElementById('hello-react'));
}