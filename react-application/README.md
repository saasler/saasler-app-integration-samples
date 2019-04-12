This project was bootstrapped with [Create React App](https://github.com/facebookincubator/create-react-app).

Below you will find some information on how to perform common tasks.<br>
You can find the most recent version of this guide [here](https://github.com/facebookincubator/create-react-app/blob/master/packages/react-scripts/template/README.md).

## Ruby file for generating private and public keys

There is a ruby file that will help you generating your keys, along with a JWT Token.

You then can use those to interact with saasler using the react application. You will be able to see the integrations you created in your account.

### Generating your keys

go to the ruby directory and bundle.

```
cd ruby
bundle
```

Open an irb session and load the gems:

```
bundle exec irb
require rubygems
require 'rbnacl'
```

Paste the code that generates the keys (Check the ruby file) and after getting the keys, put them in the file and run

```
bundle exec ruby main.rb
```

You should be able to see the information that you will paste in the react app. 

## Running the react app

After getting your keys and token. You should paste them in the file `encryption.js` inside the `src` directory.

After pasting the info there, please run the server and open the url. Make sure you setup the URL in the saasler settings.

And you should be able to see the saasler iframe load.

## Available Scripts

In the project directory, you can run:

### `npm start`

Runs the app in the development mode.<br>
Open [http://localhost:3000](http://localhost:3000) to view it in the browser.

The page will reload if you make edits.<br>
You will also see any lint errors in the console.