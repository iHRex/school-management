name: My CodeQL Analysis

# Specify the language of the codebase
language: java

# Specify the queries to run
queries:
  - path/to/first-query.ql
  - path/to/second-query.ql

# Specify the database creation and setup
database:
  source-roots:
    - path/to/source/code

# Specify additional configuration options
# (e.g., external libraries, includes, excludes, etc.)
options:
  - key: maximal-heap
    value: 4096

# Specify environment setup, if needed
environments:
  - name: my-custom-environment
    setup: path/to/setup-script.sh
