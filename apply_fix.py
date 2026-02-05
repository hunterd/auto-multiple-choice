import sys

filename = 'AMC-gui.pl.in'
with open(filename, 'r') as f:
    lines = f.readlines()

new_lines = []
i = 0
while i < len(lines):
    line = lines[i]

    # 1. Remove definition block (comments + definition)
    if "# As a workaround for Bug #93" in line:
        # We expect the next few lines to be related comments and then the definition
        # Let's verify and skip
        # comments are 3 lines, then blank, then definition, then blank
        # But let's look for the definition line to stop skipping
        found_def = False
        j = i
        while j < len(lines) and j < i + 10:
            if "my @widgets_disabled_when_preferences_opened" in lines[j]:
                found_def = True
                break
            j += 1

        if found_def:
            i = j + 1 # Skip until after definition
            # Optional: skip one more if it is a blank line that was separating this block
            if i < len(lines) and lines[i].strip() == "":
                i += 1
            continue

    # 2. Remove usage in read_glade
    if ",@widgets_disabled_when_preferences_opened);" in line:
        line = line.replace(",@widgets_disabled_when_preferences_opened);", ");")
        new_lines.append(line)
        i += 1
        continue

    # 3. Remove loops
    if "for my $k (@widgets_disabled_when_preferences_opened)" in line:
        # Assume 3 lines loop
        i += 3
        continue

    new_lines.append(line)
    i += 1

with open(filename, 'w') as f:
    f.writelines(new_lines)
