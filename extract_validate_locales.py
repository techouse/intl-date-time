import json
import re
import subprocess
from os import walk
from os.path import abspath, dirname, isfile, join, splitext
from tempfile import TemporaryDirectory

vee_validate_locale_directory = join(
    dirname(abspath(__file__)), "node_modules", "vee-validate", "dist", "locale"
)

date_format_pattern = re.compile(r"^date_format: \(field, \[format]\) => `(.*)`,?$")


def git(*args):
    return subprocess.call(
        ["git"] + list(args), stdout=subprocess.DEVNULL, stderr=subprocess.STDOUT
    )


with TemporaryDirectory() as tempdirname:
    git(
        "clone",
        "https://github.com/logaretm/vee-validate.git",
        "-b",
        "2.2.15",  # hardcoded tag - basically latest v2
        tempdirname,
        "-q",
    )

    repo_locale_directory = join(tempdirname, "locale")
    for root, dirs, files in walk(repo_locale_directory):
        for file in files:
            if file.endswith(".js") and "utils" not in file:
                with open(join(root, file), "r", encoding="utf-8") as locale:
                    for line in locale.readlines():
                        line = " ".join(line.split()).strip()
                        matches = date_format_pattern.search(line)

                        if matches:
                            date_format = (
                                matches.group(1)
                                .replace(r"${field}", r"{_field_}")
                                .replace(r"$", "")
                            )

                            locale_v3_file = join(
                                vee_validate_locale_directory,
                                splitext(file)[0] + ".json",
                            )

                            if isfile(locale_v3_file):
                                with open(
                                    locale_v3_file, "r", encoding="utf-8"
                                ) as locale_v3:
                                    locale_data = json.load(locale_v3)
                                    locale_data["messages"]["date_format"] = date_format

                                with open(
                                    locale_v3_file, "w", encoding="utf-8"
                                ) as locale_v3:
                                    json.dump(
                                        locale_data,
                                        locale_v3,
                                        indent=2,
                                        ensure_ascii=False,
                                        sort_keys=True,
                                    )
