import React from 'react';
import Alert from "@material-ui/lab/Alert";

const Error = ({response}) => {
    if (response === null) {
        return null;
    }
    const error = response.data;

    return (
        <>
            {error !== null ? <Alert severity="error">{error.message}
                {error.errors ? <ul>
                    {Object.keys(error.errors).map(el => <li key={el}>{el}: {error.errors[el]}</li>)}
                </ul> : null}
            </Alert> : null}
        </>
    );
};

export default Error;