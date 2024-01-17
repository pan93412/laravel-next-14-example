"use client";

import TocasButton from "@/components/tocas-button";
import { createStudent, deleteStudent, partialUpdateStudent } from "@/fetcher/student.actions";
import type { Student, StudentPUpdateDto, StudentRequestDto, Students } from "@/fetcher/student.types";
import { useRouter } from "next/navigation";
import React, { Dispatch, ReducerAction, useReducer, useRef, useState, useTransition } from "react";

export function StudentTable({ data }: React.PropsWithoutRef<{
  data: Students;
}>) {
  const [showNewArea, setShowNewArea] = useState(false);

  return (
    <table className="ts-table">
      <thead>
        <tr>
          <th>姓名</th>
          <th>電子郵件</th>
          <th>年級</th>
          <th>生日</th>
          <th>編輯</th>
        </tr>
      </thead>
      <tbody>
        {data.map((row) => <StudentRow key={row.id} data={row} />)}
        {showNewArea ? <NewStudentArea /> : null}
      </tbody>
      <tfoot>
        <tr>
          <th colSpan={5}>
            <button
              className="ts-button"
              onClick={() => setShowNewArea(v => !v)}
            >
              新增資料
            </button>
          </th>
        </tr>
      </tfoot>
    </table>
  );
}

function StudentRow({ data }: React.PropsWithoutRef<{ data: Student }>) {
  const [_, startTransition] = useTransition();
  const router = useRouter();

  const onModifiedBuilder = (key: keyof StudentPUpdateDto) => async (value: string) => {
    try {
      await partialUpdateStudent(data.id, {
        [key]: value,
      });

      startTransition(router.refresh);
    } catch (e) {
      alert(e);
    }
  };

  return (
    <tr>
      <td>
        <ModifiableStudentCell
          type="input"
          onModified={onModifiedBuilder("name")}
        >
          {data.name}
        </ModifiableStudentCell>
      </td>
      <td>
        <ModifiableStudentCell
          type="email"
          onModified={onModifiedBuilder("email")}
        >
          {data.email}
        </ModifiableStudentCell>
      </td>
      <td>
        <ModifiableStudentCell
          type="number"
          onModified={onModifiedBuilder("grade")}
        >
          {data.grade.toString()}
        </ModifiableStudentCell>
      </td>
      <td>
        <ModifiableStudentCell
          type="date"
          onModified={onModifiedBuilder("birthday")}
        >
          {data.birthday.toISOString().substring(0, 10)}
        </ModifiableStudentCell>
      </td>
      <td>
        <DeleteButton id={data.id} />
      </td>
    </tr>
  );
}

function ModifiableStudentCell(
  { children, type, onModified }: React.PropsWithoutRef<{
    type: React.HTMLInputTypeAttribute;
    children: string;
    onModified?: (value: string) => void;
  }>,
) {
  const [newValue, setNewValue] = useState<string>();
  const timeout = useRef<string | number | NodeJS.Timeout>();

  const commitResult = () => {
    clearTimeout(timeout.current);

    if (newValue) onModified?.(newValue);
    setNewValue(undefined);
  };

  const revokeResult = () => {
    clearTimeout(timeout.current);
    setNewValue(undefined);
  };

  const newEditInterval = () => {
    clearTimeout(timeout.current);
    timeout.current = setTimeout(() => {
      setNewValue(undefined);
    }, 3000);
  };

  return (newValue != null)
    ? (
      <div className="ts-input">
        <input
          type={type}
          value={newValue}
          onInput={(event) => setNewValue(event.currentTarget.value)}
          onKeyUp={(event) => {
            switch (event.key) {
              case "Enter":
                commitResult();
                break;
              case "Escape":
                revokeResult();
                break;
              default:
                newEditInterval();
                break;
            }
          }}
          onBlur={() => commitResult()}
        />
      </div>
    )
    : (
      <div
        onDoubleClick={() => {
          setNewValue(children);
          newEditInterval();
        }}
      >
        {children}
      </div>
    );
}

function DeleteButton({ id }: React.PropsWithoutRef<{ id: number }>) {
  const [isTransiting, startTransition] = useTransition();
  const router = useRouter();

  return (
    <TocasButton
      negative
      loading={isTransiting}
      onClick={() => {
        startTransition(async () => {
          try {
            await deleteStudent({ id });
            router.refresh();
          } catch (e) {
            alert("Failed to delete student: " + e);
          }
        });
      }}
    >
      刪除
    </TocasButton>
  );
}

function NewStudentArea() {
  const initializer = {
    name: "",
    email: "",
    grade: 0,
    birthday: "",
  } satisfies StudentFormState;
  const reducer = useReducer(studentReducer, initializer);
  const [isTransiting, startTransition] = useTransition();
  const router = useRouter();

  return (
    <tr>
      <EditableStudentCell k="name" type="text" reducer={reducer} />
      <EditableStudentCell k="email" type="email" reducer={reducer} />
      <EditableStudentCell k="grade" type="number" reducer={reducer} />
      <EditableStudentCell k="birthday" type="date" reducer={reducer} />
      <td>
        <TocasButton
          tabIndex={0}
          loading={isTransiting}
          onClick={async () => {
            const [state, action] = reducer;

            startTransition(async () => {
              try {
                await createStudent(state);
                action({ "type": "put", "content": initializer });
                router.refresh();
              } catch (e) {
                alert("Failed to create student: " + e);
              }
            });
          }}
        >
          新增
        </TocasButton>
      </td>
    </tr>
  );
}

function EditableStudentCell(
  { k, type, reducer: [state, action] }: React.PropsWithoutRef<{
    k: keyof StudentFormState;
    type: React.HTMLInputTypeAttribute;
    reducer: [StudentFormState, Dispatch<ReducerAction<typeof studentReducer<keyof StudentRequestDto>>>];
  }>,
) {
  return (
    <td>
      <div className="ts-input">
        <input
          type={type}
          value={state[k]}
          onInput={(event) => {
            action({
              type: "patch",
              key: k,
              value: event.currentTarget.value,
            });
          }}
        />
      </div>
    </td>
  );
}

type StudentFormState = StudentRequestDto;

function studentReducer<K extends keyof StudentFormState>(
  state: StudentFormState,
  action:
    | { "type": "patch"; "key": K; "value": StudentFormState[K] }
    | { "type": "put"; "content": StudentFormState },
): StudentFormState {
  switch (action.type) {
    case "patch":
      return {
        ...state,
        [action.key]: action.value,
      };
    case "put":
      return action.content;
  }
}
