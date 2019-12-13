const path = require("path");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const dev = process.env.NODE_ENV === "dev"

module.exports = {
  entry: {
    myjs: ["./assets/js/myjs.js"]
  },
  watch : dev,
  output: {
    path: path.resolve(__dirname, "assets/js/dist"),
    publicPath: "/assets/js/dist/",
    chunkFilename: '[id].bundle.js',
    filename: "[name].js"
  },
  devtool: dev ? 'cheap-module-eval-source-map ' : 'source-map',
  plugins: [
    new MiniCssExtractPlugin("filename: [name].css")
  ],
  module: {
    rules: [
      {
        test:/\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: ['babel-loader']
      },
      {
        test: /\.css$/,
        use: [
          { loader: MiniCssExtractPlugin.loader},
          { loader: 'style-loader'},
          { loader: 'css-loader'},
          { loader: 'resolve-url-loader'}
        ]
      },
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        exclude: /node_modules\/quill\/assets\/icons\/(.*)\.svg$/,
        use: [
          {
            loader: 'html-loader',
            options: {
              filename: 'images/[name].[hash:8].[ext]',
              minimize: true
            }
          }
        ]
      },
      {
        test: /\.(eot|ttf|woff|woff2)$/,
        loader: 'file-loader',
        options: {
          name: 'fonts/[name].[hash].[ext]'
        }
      }
    ]
  }
}